import { useState } from "react";
import * as XLSX from "xlsx";
import { StringBuilder } from "./utils/StringBuilder";

export function App() {
  const [assignDropSql, setAssignDropSql] = useState(false);
  const [isDragging, setIsDragging] = useState(false);
  const [processing, setProcessing] = useState(false);
  const isSupported = "showDirectoryPicker" in window;

  const selectSaveFolder = async () => {
    try {
      const dirHandle = await (window as any).showDirectoryPicker({
        mode: "readwrite",
        startIn: "desktop", // デスクトップから開始
      });

      return dirHandle;
    } catch (err) {
      if (err instanceof Error && err.name !== "AbortError") {
        console.error("フォルダ選択エラー:", err);
      }
      return null;
    }
  };

  const handleDragOver = (e: React.DragEvent) => {
    e.preventDefault();
    setIsDragging(true);
  };

  const handleDragLeave = () => {
    setIsDragging(false);
  };

  const handleDrop = async (e: React.DragEvent) => {
    e.preventDefault();
    setIsDragging(false);

    const file = e.dataTransfer.files[0];
    if (file && file.name.match(/\.(xlsx|xls)$/i)) {
      await processFile(file);
    } else {
      alert("Excelファイル(.xlsx, .xls)を選択してください");
    }
  };

  const handleFileSelect = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      await processFile(file);
    }

    e.target.value = "";
  };

  const processFile = async (file: File) => {
    setProcessing(true);

    try {
      // フォルダ選択ダイアログ表示
      const dirHandle = await selectSaveFolder();
      if (!dirHandle) {
        setProcessing(false);
        return;
      }

      // CreateSQLフォルダを作成
      const createSqlDir = await dirHandle.getDirectoryHandle("CreateSQL", {
        create: true,
      });

      // Excelファイルを読み込み
      const data = await file.arrayBuffer();
      const workbook = XLSX.read(data);

      // 2シート目以降を処理
      const sheetNames = workbook.SheetNames.slice(1);
      let fileCount = 0;

      for (const sheetName of sheetNames) {
        const worksheet = workbook.Sheets[sheetName];
        const tableDef = parseSheet(worksheet);

        if (tableDef) {
          const sql = generateCreateSql(tableDef, assignDropSql);
          const fileName = `${tableDef.schemaName}.${tableDef.tableName}.txt`;

          // ファイルを作成
          const fileHandle = await createSqlDir.getFileHandle(fileName, {
            create: true,
          });
          const writable = await fileHandle.createWritable();
          await writable.write(sql);
          await writable.close();

          fileCount++;
        }
      }

      alert(`✅${fileCount}個のSQLファイルを生成しました！`);
    } catch (err) {
      console.error("処理エラー:", err);
      alert("❌ファイルの生成に失敗しました");
    } finally {
      setProcessing(false);
    }
  };

  const parseSheet = (worksheet: XLSX.WorkSheet) => {
    const schemaName = worksheet["C4"]?.v || "";
    const logicalTableName = worksheet["C5"]?.v || "";
    const tableName = worksheet["C6"]?.v || "";

    if (!tableName) return null;

    const columns = [];
    let row = 14;

    while (true) {
      const columnName = worksheet[`C${row}`]?.v;
      if (!columnName) break;

      columns.push({
        logicalColumnName: worksheet[`B${row}`]?.v || "",
        columnName: columnName,
        dataType: worksheet[`D${row}`]?.v || "",
        notNull: worksheet[`E${row}`]?.v || "",
        default: worksheet[`F${row}`]?.v || "",
        description: worksheet[`G${row}`]?.v || "",
      });

      row++;
    }

    row += 3;
    const keys = [];

    while (true) {
      const keyName = worksheet[`B${row}`]?.v;
      if (!keyName) break;

      keys.push({
        keyName: keyName,
        columns: worksheet[`C${row}`]?.v || "",
        isPKey: worksheet[`E${row}`]?.v || "",
        isUnique: worksheet[`F${row}`]?.v || "",
      });

      row++;
    }

    return { schemaName, logicalTableName, tableName, columns, keys };
  };

  const generateCreateSql = (tableDef: any, withDrop: boolean): string => {
    const sql = new StringBuilder();

    if (withDrop) {
      sql.appendLine(`DROP TABLE ${tableDef.schemaName}.${tableDef.tableName};`);
      sql.appendLine();
    }

    sql.appendLine(`CREATE TABLE ${tableDef.schemaName}.${tableDef.tableName}(`);

    tableDef.columns.forEach((col: any, index: number) => {
      const comma = index === 0 ? "  " : "  , ";
      const notNull = col.notNull ? "NOT NULL " : "";
      const defaultVal = col.default ? `DEFAULT ${col.default}` : "";

      sql.appendLine(comma + `${col.columnName} ${col.dataType.toUpperCase()} ${notNull}${defaultVal}`.trim());
    });

    tableDef.keys.forEach((key: any) => {
      if (key.isPKey) {
        sql.appendLine(`  , CONSTRAINT ${key.keyName} PRIMARY KEY(${key.columns})`);
      }
    });

    sql.appendLine(");");

    tableDef.keys.forEach((key: any) => {
      if (!key.isPKey) {
        sql.appendLine();
        sql.appendLine(`CREATE ${key.isUnique ? "UNIQUE " : ""}INDEX ${key.keyName} ON ${tableDef.schemaName}.${tableDef.tableName}(${key.columns});`);
      }
    });

    if (tableDef.logicalTableName) {
      sql.appendLine();
      sql.appendLine("EXEC sys.sp_addextendedproperty");
      sql.appendLine("  @name       = N'MS_Description'");
      sql.appendLine(`, @value      = N'${tableDef.logicalTableName}'`);
      sql.appendLine(", @level0type = N'SCHEMA'");
      sql.appendLine(`, @level0name = N'${tableDef.schemaName}'`);
      sql.appendLine(", @level1type = N'TABLE'");
      sql.appendLine(`, @level1name = N'${tableDef.tableName}';`);
    }

    tableDef.columns.forEach((col: any) => {
      const items = [];
      if (col.logicalColumnName) items.push(col.logicalColumnName);
      if (col.description) items.push(col.description);

      if (items.length > 0) {
        sql.appendLine();
        sql.appendLine("EXEC sys.sp_addextendedproperty");
        sql.appendLine("  @name       = N'MS_Description'");
        sql.appendLine(`, @value      = N'${items.join("\r\n")}'`);
        sql.appendLine(", @level0type = N'SCHEMA'");
        sql.appendLine(`, @level0name = N'${tableDef.schemaName}'`);
        sql.appendLine(", @level1type = N'TABLE'");
        sql.appendLine(`, @level1name = N'${tableDef.tableName}'`);
        sql.appendLine(", @level2type = N'COLUMN'");
        sql.appendLine(`, @level2name = N'${col.columnName}';`);
      }
    });

    return sql.toString();
  };

  if (!isSupported) {
    return (
      <div className="mx-auto max-w-2xl p-8">
        <div className="rounded-lg border border-yellow-200 bg-yellow-50 p-6">
          <h2 className="mb-2 text-xl font-bold text-yellow-800">⚠️ブラウザ非対応</h2>
          <p className="mb-4 text-center text-yellow-700">このブラウザはファイルシステムへのアクセスに対応していないため利用できません</p>
        </div>
      </div>
    );
  }

  return (
    <div className="mx-auto max-w-2xl p-4">
      <h1 className="mb-2 text-3xl font-bold">ReverseDDL</h1>
      <p className="mb-8 text-gray-600">
        A5:SQL Mk-2のテーブル定義書からCREATE TABLE文を逆生成します。
        <br />
        クライアントサイド(ブラウザ)で処理するため、データをサーバに送信せず安心してご利用いただけます。
      </p>

      <div
        className={`cursor-pointer rounded-xl border-4 border-dashed p-16 text-center transition-all duration-200 ${
          isDragging ? "scale-105 border-blue-500 bg-blue-50" : "border-gray-300 hover:border-gray-400 hover:bg-gray-50"
        } ${processing ? "pointer-events-none opacity-50" : ""} `}
        onClick={() => document.getElementById("file-input")?.click()}
        onDragLeave={handleDragLeave}
        onDragOver={handleDragOver}
        onDrop={handleDrop}
      >
        {processing ? (
          <>
            <div className="mx-auto mb-4 h-16 w-16 animate-spin rounded-full border-b-2 border-blue-500"></div>
            <p className="font-medium text-gray-600">処理中...</p>
          </>
        ) : (
          <>
            <div className="mb-4 text-6xl">📊</div>
            <p className="mb-2 text-xl font-medium text-gray-700">Excelファイルをドロップ</p>
            <p className="text-sm text-gray-500">またはクリックしてファイルを選択</p>
          </>
        )}
        <input accept=".xlsx,.xls" className="hidden" disabled={processing} id="file-input" onChange={handleFileSelect} type="file" />
      </div>

      <div className="mt-8 rounded-lg border border-gray-300 bg-gray-50 p-6">
        <h3 className="mb-4 font-semibold text-gray-800">⚙️オプション</h3>
        <label className="flex cursor-pointer items-center rounded p-2 transition-colors hover:bg-white">
          <input checked={assignDropSql} className="mr-3 h-4 w-4" disabled={processing} onChange={(e) => setAssignDropSql(e.target.checked)} type="checkbox" />
          <span className="text-gray-700">CREATE文の前にDROP文を出力</span>
        </label>
      </div>
    </div>
  );
}
