import { useEffect, useState } from "react";

import { useQuery, useQueryClient } from "@tanstack/react-query";
import { addSeconds } from "date-fns";

import { fetchGenApi } from "@/lib/api/genApi";

export function useTopGenApiQuery() {
  const [listeners, setListeners] = useState(0);

  const { data, isSuccess } = useQuery<GenApiResponseType>({
    queryKey: ["genApiRes", 1],
    queryFn: () => fetchGenApi(1),
    staleTime: 10 * 60 * 1000,
  });

  const queryClient = useQueryClient();

  useEffect(() => {
    if (isSuccess && data.data[0]) {
      setListeners(data.data[0].LISTENERS);

      const reload = addSeconds(new Date(data.data[0].SONGEND), 15);
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
  }, [data]);

  return { listeners };
}
