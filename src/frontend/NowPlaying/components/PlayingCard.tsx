import { Button } from "@/components/ui/button";
import {
  CardTitle,
  CardDescription,
  CardContent,
  Card,
} from "@/components/ui/card";

export function PlayingCard({ param }: { param: GenType }) {
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
          <Button className="hover:bg-transparent" variant="ghost">
            <svg
              className="absolute size-8 fill-pink-500 stroke-pink-500"
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="2"
              viewBox="0 0 24 24"
            >
              <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
            </svg>
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
            <div className="absolute left-0 top-0 h-full w-1/2 bg-yellow-500" />
          </div>
        </div>
        <div className="text-muted-foreground mt-3 flex justify-end text-sm">
          3:35
        </div>
      </div>
      <div className="text-muted-foreground grid grid-cols-4 p-2 text-center text-[10px]">
        <div>RATING {param.RATING.toFixed(2)}</div>
        <div>WEEK {param.IN_WEEK}</div>
        <div>MONTH {param.IN_MONTH}</div>
        <div className="">YEAR {param.IN_YEAR}</div>
      </div>
    </Card>
  );
}
