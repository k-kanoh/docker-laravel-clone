import { useQueryClient } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import { Drawer, DrawerContent, DrawerTrigger } from "@/components/ui/drawer";
import {
  Table,
  TableBody,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { cn } from "@/lib/utils";
import { GenGridRow } from "./components/GenGridRow";
import { ListenersGraph } from "./components/ListernersGraph/ListenersGraph";
import { useGenApiQuery } from "./hooks/useGenApiQuery";
import { useTopGenApiQuery } from "./hooks/useTopGenApiQuery";
import { usePage } from "./providers/page-provider";

export function NowPlaying() {
  const { setPage, paginationElement, isFavoriteView, setIsFavoriteView } =
    usePage();
  const { genApiRes, isPending } = useGenApiQuery();
  const { listeners } = useTopGenApiQuery();

  if (isPending) {
    return (
      <div className="flex h-full items-center justify-center space-x-2">
        <div className="size-3 animate-[bounce_0.7s_infinite] rounded-full bg-blue-400" />
        <div className="size-3 animate-[bounce_0.7s_infinite] rounded-full bg-yellow-400 [animation-delay:-0.2s]" />
        <div className="size-3 animate-[bounce_0.7s_infinite] rounded-full bg-red-400 [animation-delay:-0.4s]" />
      </div>
    );
  }

  const queryClient = useQueryClient();

  const handleToggleFavoriteView = () => {
    if (isFavoriteView) {
      queryClient.invalidateQueries({ queryKey: ["genApiRes", true] });
    }

    setPage(1);
    setIsFavoriteView(!isFavoriteView);
  };

  return (
    <div className="m-auto 2xl:max-w-[90%]">
      <div className="flex flex-col overflow-x-auto">
        <div className="flex justify-end gap-1">
          <Button
            className={cn(
              "my-1 h-5 rounded-xl px-2 text-xs",
              isFavoriteView
                ? "bg-pink-400 text-white hover:bg-pink-500 hover:text-white dark:bg-pink-700 dark:hover:bg-pink-600"
                : ""
            )}
            onClick={handleToggleFavoriteView}
            variant="outline"
          >
            Favorited
          </Button>
          <Drawer>
            <DrawerTrigger asChild>
              <Button
                className="my-1 h-5 rounded-xl px-2 text-xs"
                variant="outline"
              >
                Listeners:{listeners}
              </Button>
            </DrawerTrigger>
            <DrawerContent>
              <ListenersGraph />
            </DrawerContent>
          </Drawer>
        </div>
        <div className="rounded-lg border">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead />
                <TableHead>TITLE</TableHead>
                <TableHead className="hidden sm:table-cell">ARTIST</TableHead>
                <TableHead className="hidden sm:table-cell">ALBUM</TableHead>
                <TableHead className="text-center">YEAR</TableHead>
                <TableHead>CIRCLE</TableHead>
                <TableHead className="hidden text-center sm:table-cell">
                  DURATION
                </TableHead>
                <TableHead className="hidden text-center sm:table-cell">
                  SONGEND
                </TableHead>
                <TableHead className="hidden text-center sm:table-cell">
                  RATING
                </TableHead>
                <TableHead className="hidden text-center sm:table-cell">
                  WEEK
                </TableHead>
                <TableHead className="hidden text-center sm:table-cell">
                  MONTH
                </TableHead>
                <TableHead className="hidden text-center sm:table-cell">
                  YEAR
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {genApiRes?.data.map((x) => (
                <GenGridRow key={x.SONGEND.toString()} param={x} />
              ))}
            </TableBody>
          </Table>
        </div>
      </div>
      <div className="mt-2">{paginationElement}</div>
    </div>
  );
}
