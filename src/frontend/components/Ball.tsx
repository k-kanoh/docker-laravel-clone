import React from "react";
import { Position } from "@/enum/Position";

interface BallProps {
  b?: number;
  s?: number;
  o?: number;
  pos: Position;
  onClick: () => void;
}

const Ball: React.FC<BallProps> = ({ b = 0, s = 0, o = 0, pos, onClick }) => {
  let color: string = "bg-gray-300";

  switch (pos) {
    case Position.Ball1:
      if (b > 0) color = "bg-green-500";
      break;
    case Position.Ball2:
      if (b > 1) color = "bg-green-500";
      break;
    case Position.Ball3:
      if (b > 2) color = "bg-green-500";
      break;
    case Position.Strike1:
      if (s > 0) color = "bg-yellow-500";
      break;
    case Position.Strike2:
      if (s > 1) color = "bg-yellow-500";
      break;
    case Position.Out1:
      if (o > 0) color = "bg-red-500";
      break;
    case Position.Out2:
      if (o > 1) color = "bg-red-500";
      break;
    case Position.Out3:
      if (o > 2) color = "bg-red-500";
      break;
  }

  return (
    <button
      className={`size-16 rounded-full ${color}`}
      onClick={onClick}
    ></button>
  );
};

export default Ball;
