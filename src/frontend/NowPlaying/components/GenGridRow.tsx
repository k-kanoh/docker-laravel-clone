import { useEffect, useState } from "react";

import { format, formatDistanceToNowStrict, setSeconds } from "date-fns";
import { ja } from "date-fns/locale";

import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import { TableRow, TableCell } from "@/components/ui/table";

import { PlayingCard } from "./PlayingCard";

export function GenGridRow({ param }: { param: GenType }) {
  const calcProgress = () => {
    const start = param.SONGSTART.getTime();
    const end = param.SONGEND.getTime();
    const now = new Date().getTime();

    let seconds: number;
    let percentage: string;

    if (now >= end) {
      seconds = param.DURATION;
      percentage = "100%";
    } else {
      seconds = (now - start) / 1000;
      percentage = `${((now - start) / (end - start)) * 100}%`;
    }

    return { seconds, percentage };
  };

  const [progress, setProgress] = useState(() => calcProgress());
  const [remainingTime, setRemainingTime] = useState(() =>
    formatDistanceToNowStrict(param.SONGEND, {
      locale: ja,
      addSuffix: true,
    })
  );

  useEffect(() => {
    const timer = setInterval(() => {
      setProgress(calcProgress());
      setRemainingTime(
        formatDistanceToNowStrict(param.SONGEND, {
          locale: ja,
          addSuffix: true,
        })
      );
    }, 1000);

    return () => clearInterval(timer);
  }, []);

  return (
    <TableRow>
      <TableCell className="p-2">
        <Popover>
          <PopoverTrigger>
            {(param.ALBUMART && (
              <img
                className="aspect-square min-w-12 max-w-12 rounded-md object-cover sm:min-w-20 sm:max-w-20"
                src={`https://cixi.sakura.ne.jp/ALBUMART/${param.ALBUMART}`}
              />
            )) ?? (
              <div className="size-12 rounded-md bg-yellow-200 sm:size-20 dark:bg-gray-800">
                <div className="flex size-full items-center justify-center text-[8px] sm:text-xs">
                  NO IMAGE
                </div>
              </div>
            )}
          </PopoverTrigger>
          <PopoverContent
            className="w-72 border-none bg-transparent p-0 shadow-none sm:w-96"
            collisionPadding={10}
            side="right"
          >
            <PlayingCard
              param={param}
              progress={progress}
              remainingTime={remainingTime}
            />
          </PopoverContent>
        </Popover>
      </TableCell>
      <TableCell>{param.TITLE}</TableCell>
      <TableCell className="hidden sm:table-cell">{param.ARTIST}</TableCell>
      <TableCell className="hidden sm:table-cell">{param.ALBUM}</TableCell>
      <TableCell className="text-center">{param.YEAR}</TableCell>
      <TableCell>{param.CIRCLE}</TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {format(setSeconds(new Date(0), param.DURATION), "m:ss")}
      </TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {remainingTime}
      </TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {param.RATING.toFixed(2)}
      </TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {param.IN_WEEK}
      </TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {param.IN_MONTH}
      </TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {param.IN_YEAR}
      </TableCell>
    </TableRow>
  );
}
