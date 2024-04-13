import { useEffect, useState } from "react";

import { useQuery, useQueryClient } from "@tanstack/react-query";
import { addSeconds } from "date-fns";

import { fetchGenApi } from "@/lib/api/genApi";

import { usePage } from "../providers/page-provider";

export function useGenApiQuery() {
  const { page } = usePage();
  const [listeners, setListeners] = useState(0);

  const { data: genApiRes, isPending } = useQuery({
    queryKey: ["genApiRes", page],
    queryFn: () => fetchGenApi(page),
    staleTime: 10 * 60 * 1000,
  });

  const { data: topGenApiRes, isSuccess } = useQuery<GenApiResponseType>({
    queryKey: ["genApiRes", 1],
    queryFn: () => fetchGenApi(1),
    staleTime: 10 * 60 * 1000,
  });

  const queryClient = useQueryClient();

  useEffect(() => {
    if (isSuccess && topGenApiRes.data[0]) {
      setListeners(topGenApiRes.data[0].LISTENERS);

      const reload = addSeconds(new Date(topGenApiRes.data[0].SONGEND), 15);
      const reloadRemaining = reload.valueOf() - new Date().valueOf();

      if (reloadRemaining > 0) {
        const timer = setTimeout(
          () => queryClient.invalidateQueries(),
          reloadRemaining
        );

        return () => clearTimeout(timer);
      }
    }

    return;
  }, [topGenApiRes]);

  return { genApiRes, isPending, listeners };
}
