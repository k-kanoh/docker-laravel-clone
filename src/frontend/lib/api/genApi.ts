import { ApiError } from "@/lib/errors/ApiError";

export const fetchGenApi = async (page: number) => {
  const response = await fetch(`/api/gen?page=${page}`);

  if (response.ok) {
    const data: GenApiResponseType = await response.json();

    data.data.forEach((x) => {
      x.SONGSTART = new Date(x.SONGSTART);
      x.SONGEND = new Date(x.SONGEND);
    });

    return data;
  }

  throw await ApiError.fromResponse(response);
};
