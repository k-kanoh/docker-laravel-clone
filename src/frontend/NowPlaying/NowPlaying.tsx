import { Ref, forwardRef, useEffect, useState } from "react";

import {
  Table,
  TableBody,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";

import { GenGridRow } from "./components/GenGridRow";
import { MyPagination } from "./components/MyPagination";
import { useGenApiRes } from "./hooks/useGenApiRes";

const NowPlayingComponent = (
  { scrollableContainerRef }: ScrollableContainerRefProps,
  ref: Ref<HTMLDivElement>
) => {
  const [page, setPage] = useState((): number => {
    const pageNumber = sessionStorage.getItem("page");
    return pageNumber ? parseInt(pageNumber, 10) : 1;
  });

  const { fetchGenApi, genApiRes } = useGenApiRes();

  useEffect(() => {
    sessionStorage.setItem("page", page.toString());
    fetchGenApi(page);
  }, [page]);

  return (
    <div className="m-auto 2xl:max-w-[90%]" ref={ref}>
      <div className="flex flex-col overflow-x-auto">
        <div className="rounded-lg border">
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
