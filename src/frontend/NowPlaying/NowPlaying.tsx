import { forwardRef, useEffect, useState } from "react";

import {
  Table,
  TableBody,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";

import { useGenApiRes } from "./Asm/customHooks";
import { GenGridRow } from "./Components/GenGridRow";
import { MyPagination } from "./Components/MyPagination";

const NowPlayingComponent = ({
  scrollableContainerRef,
}: ScrollableContainerRefProps) => {
  const [page, setPage] = useState((): number => {
    const pageNumber = sessionStorage.getItem("currPage");
    return pageNumber ? parseInt(pageNumber, 10) : 1;
  });

  const { fetchGenApi, genApiRes } = useGenApiRes();

  useEffect(() => {
    sessionStorage.setItem("currPage", page.toString());
    fetchGenApi(page);
  }, [page]);

  return (
    <div>
      <div className="flex flex-col overflow-x-auto">
        <div className="mx-auto rounded-lg border">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead className="min-w-20"></TableHead>
                <TableHead className="min-w-36">TITLE</TableHead>
                <TableHead className="min-w-36">ARTIST</TableHead>
                <TableHead className="min-w-36">ALBUM</TableHead>
                <TableHead className="text-center">YEAR</TableHead>
                <TableHead className="min-w-36">CIRCLE</TableHead>
                <TableHead className="text-center">DURATION</TableHead>
                <TableHead className="text-center">SONGEND</TableHead>
                <TableHead className="text-center">RATING</TableHead>
                <TableHead className="text-center">WEEK</TableHead>
                <TableHead className="text-center">MONTH</TableHead>
                <TableHead className="text-center">YEAR</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {genApiRes.data.map((x) => (
                <GenGridRow key={x.SONGEND.toString()} param={x} />
              ))}
            </TableBody>
          </Table>
        </div>
      </div>
      <div className="mt-2">
        <MyPagination
          page={page}
          scrollableContainerRef={scrollableContainerRef}
          setPage={setPage}
        />
      </div>
    </div>
  );
};

export const NowPlaying = forwardRef<
  HTMLDivElement,
  ScrollableContainerRefProps
>(NowPlayingComponent);
