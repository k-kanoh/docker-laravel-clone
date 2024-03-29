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
}: {
  page: number;
  setPage: (page: number) => void;
}) {
  return (
    <Pagination>
      <PaginationContent className="gap-5">
        <PaginationItem>
          <PaginationPrevious
            className={
              page === 1 ? "text-muted-foreground pointer-events-none" : ""
            }
            onClick={() => setPage(page - 1)}
          />
        </PaginationItem>
        <PaginationItem>{page}</PaginationItem>
        <PaginationItem>
          <PaginationNext onClick={() => setPage(page + 1)} />
        </PaginationItem>
      </PaginationContent>
    </Pagination>
  );
}
