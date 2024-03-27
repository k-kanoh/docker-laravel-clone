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
            aria-disabled={page === 1}
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
