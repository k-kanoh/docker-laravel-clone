import { useMutation, useQueryClient } from "@tanstack/react-query";
import { addFavorite, removeFavorite } from "@/lib/api/favoriteApi";
import { usePage } from "../providers/page-provider";
import { useGenApiQuery } from "./useGenApiQuery";

export function useFavoriteMutation() {
  const { isFavoriteView } = usePage();
  const { replaceGenApiRes } = useGenApiQuery();

  const queryClient = useQueryClient();

  const addFavoriteMutation = useMutation({
    mutationFn: (id: number) => addFavorite(id),
    onSuccess: (result) => {
      replaceGenApiRes(result);
      queryClient.invalidateQueries({
        queryKey: ["genApiRes", !isFavoriteView],
      });
    },
  });

  const removeFavoriteMutation = useMutation({
    mutationFn: (id: number) => removeFavorite(id),
    onSuccess: (result) => {
      replaceGenApiRes(result);
      queryClient.invalidateQueries({
        queryKey: ["genApiRes", !isFavoriteView],
      });
    },
  });

  return { addFavoriteMutation, removeFavoriteMutation };
}
