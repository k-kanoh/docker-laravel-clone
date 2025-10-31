import { getCSRFToken } from "@/lib/csrf";
import { ApiError } from "@/lib/errors/ApiError";

export const addFavorite = async (id: number) => {
  const response = await fetch("/api/favorite", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      "X-CSRF-Token": getCSRFToken(),
    },
    credentials: "same-origin",
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
      Accept: "application/json",
      "X-CSRF-Token": getCSRFToken(),
    },
    credentials: "same-origin",
  });

  if (response.ok) {
    const data: GenType = await response.json();
    data.SONGSTART = new Date(data.SONGSTART);
    data.SONGEND = new Date(data.SONGEND);
    return data;
  }

  throw await ApiError.fromResponse(response);
};
