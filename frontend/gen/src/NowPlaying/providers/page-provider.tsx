import { createContext, useContext, useEffect, useState } from "react";
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from "@/components/ui/pagination";

interface PageProviderState {
  page: number;
  setPage: (page: number) => void;
  pageReset: () => void;
  setPagination: (pagination: {
    isPrevable: boolean;
    isNextable: boolean;
  }) => void;
  paginationElement: JSX.Element;
  isFavoriteView: boolean;
  setIsFavoriteView: (isFavoriteView: boolean) => void;
}

const PageProviderContext = createContext<PageProviderState>({
  page: 1,
  setPage: () => null,
  pageReset: () => null,
  setPagination: () => null,
  paginationElement: <></>,
  isFavoriteView: false,
  setIsFavoriteView: () => null,
});

export function PageProvider({
  children,
  onPageChanged,
  ...props
}: {
  children: React.ReactNode;
  onPageChanged?: () => void;
}) {
  const [page, setPage] = useState(() =>
    parseInt(sessionStorage.getItem("page") ?? "1")
  );
  const [isFavoriteView, setIsFavoriteView] = useState(false);

  useEffect(() => {
    sessionStorage.setItem("page", page.toString());
    onPageChanged?.();
  }, [page]);

  const pageReset = () => {
    if (page === 1) {
      onPageChanged?.();
    } else {
      setPage(1);
    }
  };

  const [pagination, setPagination] = useState({
    isPrevable: false,
    isNextable: false,
  });

  const paginationElement = (
    <Pagination>
      <PaginationContent className="gap-5">
        <PaginationItem>
          <PaginationPrevious
            className={
              pagination.isPrevable
                ? ""
                : "text-muted-foreground pointer-events-none"
            }
            onClick={() => setPage(page - 1)}
          />
        </PaginationItem>
        <PaginationItem>{page}</PaginationItem>
        <PaginationItem>
          <PaginationNext
            className={
              pagination.isNextable
                ? ""
                : "text-muted-foreground pointer-events-none"
            }
            onClick={() => setPage(page + 1)}
          />
        </PaginationItem>
      </PaginationContent>
    </Pagination>
  );

  const value = {
    page,
    setPage,
    pageReset,
    setPagination,
    paginationElement,
    isFavoriteView,
    setIsFavoriteView,
  };

  return (
    <PageProviderContext.Provider {...props} value={value}>
      {children}
    </PageProviderContext.Provider>
  );
}

export const usePage = () => useContext(PageProviderContext);
