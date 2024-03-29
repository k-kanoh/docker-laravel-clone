import { createContext, useContext, useEffect, useState } from "react";

import { useGenApiRes } from "../hooks/useGenApiRes";

interface PageProviderState {
  page: number;
  setPage: (page: number) => void;
  pageReset: () => void;
  genApiRes: GenApiResponseType;
}

const PageProviderContext = createContext<PageProviderState>({
  page: 1,
  setPage: () => null,
  pageReset: () => null,
  genApiRes: {
    current_page: 1,
    data: [],
    last_page: 1,
    total: 0,
  },
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

  const { fetchGenApi, genApiRes } = useGenApiRes();

  useEffect(() => {
    sessionStorage.setItem("page", page.toString());
    fetchGenApi(page);
    onPageChanged?.();
  }, [page]);

  const pageReset = () => {
    if (page === 1) {
      fetchGenApi(page);
      onPageChanged?.();
    } else {
      setPage(1);
    }
  };

  const value = {
    page,
    setPage,
    pageReset,
    genApiRes: genApiRes,
  };

  return (
    <PageProviderContext.Provider {...props} value={value}>
      {children}
    </PageProviderContext.Provider>
  );
}

export const usePage = () => useContext(PageProviderContext);
