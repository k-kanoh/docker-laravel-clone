import { useState } from "react";

export function useGenApiRes() {
  const [genApiRes, setGenApiRes] = useState<GenApiResponseType>({
    current_page: 1,
    data: [],
    last_page: 1,
    total: 0,
  });

  const fetchGenApi = async (page: number) => {
    try {
      const res = await fetch(`https://cixi.sakura.ne.jp/api/gen?page=${page}`);
      const data: GenApiResponseType = await res.json();

      data.data.forEach((x) => {
        x.SONGSTART = new Date(x.SONGSTART);
        x.SONGEND = new Date(x.SONGEND);
      });

      setGenApiRes(data);
    } catch (err) {
      console.error(err);
    }
  };

  return { fetchGenApi, genApiRes };
}
