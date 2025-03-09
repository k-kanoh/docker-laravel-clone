import { useEffect, useRef, useState } from "react";
import { useQuery, useQueryClient } from "@tanstack/react-query";
import { addSeconds } from "date-fns";
import { fetchGenApi } from "@/lib/api/genApi";

export function useTopGenApiQuery() {
  const [listeners, setListeners] = useState<number | null>(0);

  const { data, isSuccess, isFetching } = useQuery<GenApiResponseType>({
    queryKey: ["genApiRes", false, 1],
    queryFn: () => fetchGenApi(1, false),
    staleTime: 10 * 60 * 1000,
  });

  const isFetchingRef = useRef(false);

  const queryClient = useQueryClient();

  useEffect(() => {
    isFetchingRef.current = isFetching;
  }, [isFetching]);

  useEffect(() => {
    if (isSuccess && data.data[0]) {
      setListeners(data.data[0].LISTENERS);

      const reload = addSeconds(new Date(data.data[0].SONGEND), 5);
      const reloadRemaining = reload.valueOf() - new Date().valueOf();

      let timer: NodeJS.Timeout;

      if (reloadRemaining > 0) {
        timer = setTimeout(() => {
          if (!isFetchingRef.current) {
            queryClient.invalidateQueries();
          }
        }, reloadRemaining);
      } else {
        timer = setInterval(() => {
          if (!isFetchingRef.current) {
            queryClient.invalidateQueries();
          }
        }, 10 * 1000);
      }

      return () => {
        clearTimeout(timer);
        clearInterval(timer);
      };
    }

    return;
  }, [data]);

  return { listeners };
}
