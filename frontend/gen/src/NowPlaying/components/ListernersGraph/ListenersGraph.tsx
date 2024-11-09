import { useEffect, useState } from "react";
import { useQuery } from "@tanstack/react-query";
import {
  addDays,
  addMonths,
  addYears,
  format,
  isEqual,
  startOfToday,
} from "date-fns";
import { ja } from "date-fns/locale";
import { ChevronLeft, ChevronRight, Frown } from "lucide-react";
import { useSwipeable } from "react-swipeable";
import { Button } from "@/components/ui/button";
import { listenersApi } from "@/lib/api/listenersApi";
import { cn } from "@/lib/utils";
import { ListenersChart } from "./ListenersChart";
import { ListenersFilterMenu } from "./ListenersFilterMenu";

export function ListenersGraph() {
  const [filterMode, setFilterMode] = useState<FilterMode>(
    () =>
      (sessionStorage.getItem("lisSummaryFilter") ??
        "recentHourly") as FilterMode
  );
  const [currDate, setCurrDate] = useState(startOfToday());

  const { data, isSuccess, isError } = useQuery({
    queryKey: ["genListeners", filterMode, currDate],
    queryFn: () => listenersApi(filterMode, currDate),
    retry: (failureCount, error: ApiError) =>
      error.status === 404 ? false : failureCount < 3,
    staleTime: 10 * 60 * 1000,
  });

  type FilterModeEffect = {
    caption: string;
    dateAction: (date: Date) => string;
    addAction: (date: Date, amount: number) => Date;
  };

  const [filterModeEffect, setFilterModeEffect] = useState<FilterModeEffect>({
    caption: "",
    dateAction: () => "",
    addAction: (date) => date,
  });

  useEffect(() => {
    sessionStorage.setItem("lisSummaryFilter", filterMode);
    setCurrDate(startOfToday());

    switch (filterMode) {
      case "recentHourly":
        setFilterModeEffect({
          caption: "スポット(一日)",
          dateAction: (date) => format(date, "yyyy/MM/dd(eee)", { locale: ja }),
          addAction: addDays,
        });
        break;

      case "recentDaily":
        setFilterModeEffect({
          caption: "スポット(一か月)",
          dateAction: (date) => format(date, "yyyy/MM"),
          addAction: addMonths,
        });
        break;

      case "recentMonthly":
        setFilterModeEffect({
          caption: "スポット(一年)",
          dateAction: (date) => format(date, "yyyy"),
          addAction: addYears,
        });
        break;

      case "overallHourly":
        setFilterModeEffect({
          caption: "全データ(24時間)",
          dateAction: () => "",
          addAction: (date) => date,
        });
        break;

      case "overallWeekly":
        setFilterModeEffect({
          dateAction: () => "",
          caption: "全データ(曜日)",
          addAction: (date) => date,
        });
    }
  }, [filterMode]);

  const handlePrevDate = () =>
    setCurrDate((date) => filterModeEffect.addAction(date, -1));

  const handleNextDate = () =>
    setCurrDate((date) => filterModeEffect.addAction(date, 1));

  const handlers = useSwipeable({
    onSwipedLeft: () => handleNextDate(),
    onSwipedRight: () => handlePrevDate(),
  });

  const chartRendering = () => {
    if (isSuccess) {
      return <ListenersChart data={data} />;
    }

    if (isError) {
      return (
        <div className="flex flex-col items-center gap-1">
          <Frown className="flex size-20 stroke-gray-400" />
          <div className="text-2xl uppercase">not found</div>
        </div>
      );
    }

    return;
  };

  return (
    <div className="mx-2">
      <div className="mx-auto mb-2 max-w-[500px]">
        <div className="my-1 flex justify-between">
          <h2 className="flex items-center text-sm font-bold">
            {filterModeEffect.caption}
          </h2>
          <ListenersFilterMenu
            filterMode={filterMode}
            setFilterMode={setFilterMode}
          />
        </div>
        <div className="relative" {...handlers}>
          <div className="flex h-48 flex-col items-center justify-center rounded-lg border p-0 sm:p-2">
            {chartRendering()}
          </div>
          <div
            className={
              filterMode.startsWith("overall")
                ? "hidden"
                : "bg-background text-foreground absolute -top-4 left-1/2 -translate-x-1/2 rounded-md border px-3 py-1 text-sm font-bold shadow-md"
            }
          >
            <a
              className={cn(
                "cursor-pointer",
                isEqual(startOfToday(), currDate)
                  ? "text-foreground pointer-events-none"
                  : ""
              )}
              onClick={() => setCurrDate(startOfToday())}
            >
              {filterModeEffect.dateAction(currDate)}
            </a>
          </div>
          <Button
            className={
              filterMode.startsWith("overall")
                ? "hidden"
                : "absolute -left-9 top-1/2 hidden size-8 -translate-y-1/2 rounded-full p-0 sm:flex"
            }
            onClick={handlePrevDate}
            variant="outline"
          >
            <ChevronLeft className="size-6 stroke-gray-400" />
          </Button>
          <Button
            className={
              filterMode.startsWith("overall")
                ? "hidden"
                : "absolute -right-9 top-1/2 hidden size-8 -translate-y-1/2 rounded-full p-0 sm:flex"
            }
            onClick={handleNextDate}
            variant="outline"
          >
            <ChevronRight className="size-6 stroke-gray-400" />
          </Button>
        </div>
      </div>
    </div>
  );
}
