import { getCSRFToken } from "@/lib/csrf";
import { ApiError } from "@/lib/errors/ApiError";

export const addFavorite = async (id: number) => {
  const response = await fetch("/api/favorite", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-Token": getCSRFToken(),
    },
    body: JSON.stringify({ id }),
  });

  if (response.ok) {
    const data: GenType = await response.json();
    data.SONGSTART = new Date(data.SONGSTART);
    data.SONGEND = new Date(data.SONGEND);
    return data;
  }

  throw await ApiError.fromResponse(response);
};

export const removeFavorite = async (id: number) => {
  const response = await fetch(`/api/favorite/${id}`, {
    method: "DELETE",
    headers: {
      "X-CSRF-Token": getCSRFToken(),
    },
  });

  if (response.ok) {
    const data: GenType = await response.json();
    data.SONGSTART = new Date(data.SONGSTART);
    data.SONGEND = new Date(data.SONGEND);
    return data;
  }

  throw await ApiError.fromResponse(response);
};
