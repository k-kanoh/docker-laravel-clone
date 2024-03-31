import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import { TableRow, TableCell } from "@/components/ui/table";

import { PlayingCard } from "./PlayingCard";

export function GenGridRow({ param }: { param: GenType }) {
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
            side="right"
          >
            <PlayingCard param={param} />
          </PopoverContent>
        </Popover>
      </TableCell>
      <TableCell>{param.TITLE}</TableCell>
      <TableCell className="hidden sm:table-cell">{param.ARTIST}</TableCell>
      <TableCell className="hidden sm:table-cell">{param.ALBUM}</TableCell>
      <TableCell className="text-center">{param.YEAR}</TableCell>
      <TableCell>{param.CIRCLE}</TableCell>
      <TableCell className="hidden text-center sm:table-cell">
        {param.DURATION}
      </TableCell>
      <TableCell className="hidden text-nowrap sm:table-cell">
        {param.SONGEND.toString()}
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
