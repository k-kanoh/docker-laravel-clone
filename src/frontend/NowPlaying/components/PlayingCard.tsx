import { format, setSeconds } from "date-fns";
import { toast } from "sonner";

import { HeartIcon } from "@/Icons/HeartIcon";
import { Button } from "@/components/ui/button";
import {
  CardTitle,
  CardDescription,
  CardContent,
  Card,
} from "@/components/ui/card";

import { useFavoriteMutation } from "../hooks/useFavoriteMutation";

export function PlayingCard({
  param,
  progress,
  remainingTime,
}: {
  param: GenType;
  progress: { seconds: number; percentage: string };
  remainingTime: string;
}) {
  const { addFavoriteMutation, removeFavoriteMutation } = useFavoriteMutation();

  const handleToggleFavoriteState = () => {
    if (param.favorited_at) {
      removeFavoriteMutation.mutate(param.ID, {
        onSuccess: () => {
          toast.success("お気に入りを解除しました", {
            icon: <HeartIcon isFill={false} />,
            classNames: {
              toast: "group-[.toaster]:bg-white",
              title: "text-black",
            },
          });
        },
        onError: (error) => {
          const e = error as ApiError;
          toast.error(`${e.status} ${e.message}`);
        },
      });
    } else {
      addFavoriteMutation.mutate(param.ID, {
        onSuccess: () => {
          toast.success("お気に入りに登録しました", {
            icon: <HeartIcon isFill={true} />,
            classNames: {
              toast: "group-[.toaster]:bg-pink-100",
              title: "text-red-500",
            },
          });
        },
        onError: (error) => {
          const e = error as ApiError;
          toast.error(`${e.status} ${e.message}`);
        },
      });
    }
  };

  return (
    <Card className="overflow-hidden shadow-lg dark:shadow-slate-800">
      <div className="relative">
        {(param.ALBUMART && (
          <img
            className="aspect-[4/3] w-full object-cover"
            src={`https://cixi.sakura.ne.jp/ALBUMART/${param.ALBUMART}`}
          />
        )) ?? (
          <div className="aspect-[4/3] w-full bg-yellow-200 dark:bg-gray-900">
            <div className="flex size-full items-center justify-center">
              NO IMAGE
            </div>
          </div>
        )}
        <div className="absolute right-2 top-0">
          <Button onClick={handleToggleFavoriteState} variant="transparent">
            <HeartIcon
              className="absolute size-8"
              isFill={!!param.favorited_at}
            />
          </Button>
        </div>
      </div>
      <CardContent className="p-3">
        <div className="grid gap-2">
          <CardTitle>
            <div className="flex items-center gap-2">
              <svg
                className="size-6 min-w-6 stroke-yellow-500"
                fill="none"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M9 18V5l12-2v13" />
                <circle cx="6" cy="18" r="3" />
                <circle cx="18" cy="16" r="3" />
              </svg>
              {param.TITLE}
            </div>
          </CardTitle>
          <CardDescription>
            <div>{param.ARTIST}</div>
            <div className="pl-1">
              『{param.ALBUM}』 ({param.YEAR}) Produced by {param.CIRCLE}
            </div>
          </CardDescription>
        </div>
      </CardContent>
      <div className="px-6 pb-3">
        <div className="w-full">
          <div className="bg-accent relative mt-1 h-1 overflow-hidden rounded">
            <div
              className="absolute left-0 top-0 h-full bg-yellow-500"
              style={{ width: progress.percentage }}
            />
          </div>
        </div>
        <div className="text-muted-foreground mt-3 flex justify-between text-sm">
          <div>{format(setSeconds(new Date(0), progress.seconds), "m:ss")}</div>
          <div>
            {format(setSeconds(new Date(0), param.DURATION), "m:ss")}
            <span className="sm:hidden">({remainingTime})</span>
          </div>
        </div>
      </div>
      <div className="text-muted-foreground grid grid-cols-4 p-2 text-center text-[10px]">
        <div className="col-span-2">
          START {format(param.SONGSTART, "M/d H:mm:ss")}
        </div>
        <div className="col-span-2">
          END {format(param.SONGEND, "M/d H:mm:ss")}
        </div>
        <div>RATING {param.RATING?.toFixed(2) ?? "-"}</div>
        <div>WEEK {param.IN_WEEK}</div>
        <div>MONTH {param.IN_MONTH}</div>
        <div>YEAR {param.IN_YEAR}</div>
      </div>
    </Card>
  );
}
