import { createContext, useContext, useEffect, useState } from "react";

interface PageProviderState {
  page: number;
  setPage: (page: number) => void;
  pageReset: () => void;
}

const PageProviderContext = createContext<PageProviderState>({
  page: 1,
  setPage: () => null,
  pageReset: () => null,
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

  const value = {
    page,
    setPage,
    pageReset,
  };

  return (
    <PageProviderContext.Provider {...props} value={value}>
      {children}
    </PageProviderContext.Provider>
  );
}

export const usePage = () => useContext(PageProviderContext);
