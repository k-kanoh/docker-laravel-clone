import { useState } from "react";

export function useGenApiRes() {
  const [genApiRes, setGenApiRes] = useState<GenApiResponseType>({
    current_page: 1,
    data: [],
    last_page: 1,
    total: 0,
  });

  const fetchGenApi = async (currentPage: number) => {
    try {
      const res = await fetch(`/api/gen?page=${currentPage}`);
      const data: GenApiResponseType = await res.json();
      setGenApiRes(data);
    } catch (err) {
      console.error(err);
    }
  };

  return { fetchGenApi, genApiRes };
}
