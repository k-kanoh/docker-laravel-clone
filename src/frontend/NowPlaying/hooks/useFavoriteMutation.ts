import { useMutation } from "@tanstack/react-query";

import { addFavorite, removeFavorite } from "@/lib/api/favoriteApi";

import { useGenApiQuery } from "./useGenApiQuery";

export function useFavoriteMutation() {
  const { replaceGenApiRes } = useGenApiQuery();

  const addFavoriteMutation = useMutation({
    mutationFn: (id: number) => addFavorite(id),
    onSuccess: (result) => replaceGenApiRes(result),
  });

  const removeFavoriteMutation = useMutation({
    mutationFn: (id: number) => removeFavorite(id),
    onSuccess: (result) => replaceGenApiRes(result),
  });

  return { addFavoriteMutation, removeFavoriteMutation };
}
