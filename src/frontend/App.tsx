import sum from "lodash/sum";
import { useState } from "react";
import { Button } from "./components/ui/button";
import { Position } from "./enum/Position";
import Ball from "@/components/Ball";

function App() {
  const [bCount, setBCount] = useState(0);
  const [sCount, setSCount] = useState(0);
  const [oCount, setOCount] = useState(0);
  const [batterResult, setBatterResult] = useState<number[]>([]);

  const bClick = () => {
    if (oCount === 3) return;

    if (bCount === 3) {
      setBatterResult([...batterResult, bCount + sCount + 1]);
      setBCount(0);
      setSCount(0);
    } else {
      setBCount((x) => x + 1);
    }
  };

  const sClick = () => {
    if (oCount === 3) return;

    setSCount((x) => x + 1);
  };

  const oClick = () => {
    setBatterResult([...batterResult, bCount + sCount + 1]);
    setBCount(0);
    setSCount(0);

    if (oCount === 3) {
      setOCount(0);
      setBatterResult([]);
    } else {
      setOCount((x) => x + 1);
    }
  };

  return (
    <div className="absolute inset-0 flex items-center justify-center bg-cyan-100">
      <div className="flex flex-col justify-center gap-2 rounded-2xl bg-slate-200 px-4 py-10">
        <div className="flex gap-2 rounded-sm bg-red-200 p-1">
          <Ball b={bCount} onClick={bClick} pos={Position.Ball1} />
          <Ball b={bCount} onClick={bClick} pos={Position.Ball2} />
          <Ball b={bCount} onClick={bClick} pos={Position.Ball3} />
        </div>
        <div className="flex gap-2 rounded-sm bg-red-200 p-1">
          <Ball onClick={sClick} pos={Position.Strike1} s={sCount} />
          <Ball onClick={sClick} pos={Position.Strike2} s={sCount} />
        </div>
        <div className="flex gap-2 rounded-sm bg-red-200 p-1">
          <Ball o={oCount} onClick={oClick} pos={Position.Out1} />
          <Ball o={oCount} onClick={oClick} pos={Position.Out2} />
          <Ball o={oCount} onClick={oClick} pos={Position.Out3} />
        </div>
        <div className="mb-4 text-center text-3xl">
          <div>バッター: {bCount + sCount}球</div>
          <div>イニング: {sum(batterResult) + bCount + sCount}球</div>
        </div>
        <Button
          className="bg-blue-500 text-lg hover:bg-blue-600"
          onClick={() => {
            if (oCount === 3) return;
            setBatterResult([...batterResult, bCount + sCount + 1]);
            setBCount(0);
            setSCount(0);
          }}
        >
          ヒット等
        </Button>
        <Button
          className="bg-blue-500 text-lg hover:bg-blue-600"
          onClick={() => {
            setBatterResult([]);
            setBCount(0);
            setSCount(0);
            setOCount(0);
          }}
        >
          Reset
        </Button>
      </div>
    </div>
  );
}

export default App;
