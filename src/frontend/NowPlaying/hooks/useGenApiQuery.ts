import { useEffect } from "react";

import { useQuery, useQueryClient } from "@tanstack/react-query";

import { fetchGenApi } from "@/lib/api/genApi";

import { usePage } from "../providers/page-provider";

export function useGenApiQuery() {
  const { page, setPagination } = usePage();

  const {
    data: genApiRes,
    isPending,
    isSuccess,
  } = useQuery({
    queryKey: ["genApiRes", page],
    queryFn: () => fetchGenApi(page),
    staleTime: 10 * 60 * 1000,
  });

  useEffect(() => {
    if (isSuccess) {
      setPagination({
        isPrevable: !!genApiRes.prev_page_url,
        isNextable: !!genApiRes.next_page_url,
      });
    }
  }, [genApiRes]);

  const queryClient = useQueryClient();

  const replaceGenApiRes = (replaceRecord: GenType) => {
    queryClient.setQueryData(
      ["genApiRes", page],
      (oldData: GenApiResponseType) => {
        return {
          ...oldData,
          data: oldData.data.map((x) =>
            x.ID === replaceRecord.ID ? replaceRecord : x
          ),
        };
      }
    );
  };

  return { genApiRes, isPending, replaceGenApiRes };
}
