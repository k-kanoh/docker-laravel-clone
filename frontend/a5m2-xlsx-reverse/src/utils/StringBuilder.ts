/**
 * StringBuilder - C#のStringBuilderライクなユーティリティクラス
 *
 * 文字列を効率的に連結するためのクラス。
 * メソッドチェーンで流れるように記述できます。
 *
 * @example
 * ```typescript
 * const sb = new StringBuilder();
 * const result = sb
 *   .appendLine("SELECT *")
 *   .appendLine("FROM users")
 *   .appendLine("WHERE id = 1;")
 *   .toString();
 * ```
 */
export class StringBuilder {
  private lines: string[] = [];

  /**
   * テキストを追加して改行
   * @param text - 追加するテキスト（省略時は空行）
   */
  appendLine(text: string = ""): this {
    this.lines.push(text + "\r\n");
    return this;
  }

  /**
   * 文字列に変換
   */
  toString(): string {
    return this.lines.join("");
  }

  /**
   * 内容をクリア
   */
  clear(): this {
    this.lines = [];
    return this;
  }
}
