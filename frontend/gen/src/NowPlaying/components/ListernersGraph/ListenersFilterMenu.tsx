import { ListFilter } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

export function ListenersFilterMenu({
  filterMode,
  setFilterMode,
}: {
  filterMode: FilterMode;
  setFilterMode: (mode: FilterMode) => void;
}) {
  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button
          className="my-1 h-5 gap-1 rounded-xl px-2 text-xs"
          variant="outline"
        >
          <ListFilter className="size-3.5" />
          Filter
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        <DropdownMenuLabel>スポット</DropdownMenuLabel>
        <DropdownMenuCheckboxItem
          checked={filterMode === "recentHourly"}
          onClick={() => setFilterMode("recentHourly")}
        >
          Hour
        </DropdownMenuCheckboxItem>
        <DropdownMenuCheckboxItem
          checked={filterMode === "recentDaily"}
          onClick={() => setFilterMode("recentDaily")}
        >
          Day
        </DropdownMenuCheckboxItem>
        <DropdownMenuCheckboxItem
          checked={filterMode === "recentMonthly"}
          onClick={() => setFilterMode("recentMonthly")}
        >
          Month
        </DropdownMenuCheckboxItem>
        <DropdownMenuSeparator />
        <DropdownMenuLabel>全データ</DropdownMenuLabel>
        <DropdownMenuCheckboxItem
          checked={filterMode === "overallHourly"}
          onClick={() => setFilterMode("overallHourly")}
        >
          Hour
        </DropdownMenuCheckboxItem>
        <DropdownMenuCheckboxItem
          checked={filterMode === "overallWeekly"}
          onClick={() => setFilterMode("overallWeekly")}
        >
          Week
        </DropdownMenuCheckboxItem>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
