import { useQuery, useQueryClient } from "@tanstack/react-query";

import { fetchGenApi } from "@/lib/api/genApi";

import { usePage } from "../providers/page-provider";

export function useGenApiQuery() {
  const { page } = usePage();

  const { data: genApiRes, isPending } = useQuery({
    queryKey: ["genApiRes", page],
    queryFn: () => fetchGenApi(page),
    staleTime: 10 * 60 * 1000,
  });

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
