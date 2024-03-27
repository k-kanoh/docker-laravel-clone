import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from "@/components/ui/pagination";

export function MyPagination({
  page,
  setPage,
  scrollableContainerRef,
}: PaginationProps & ScrollableContainerRefProps) {
  return (
    <Pagination>
      <PaginationContent className="gap-5">
        <PaginationItem>
          <PaginationPrevious
            className={
              page === 1 ? "text-muted-foreground pointer-events-none" : ""
            }
            onClick={() => {
              setPage(page - 1);
              scrollableContainerRef?.current?.scrollTo(0, 0);
            }}
          />
        </PaginationItem>
        <PaginationItem>{page}</PaginationItem>
        <PaginationItem>
          <PaginationNext
            onClick={() => {
              setPage(page + 1);
              scrollableContainerRef?.current?.scrollTo(0, 0);
            }}
          />
        </PaginationItem>
      </PaginationContent>
    </Pagination>
  );
}
