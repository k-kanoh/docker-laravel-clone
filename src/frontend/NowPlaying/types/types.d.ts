interface GenType {
  ID: number;
  TITLE: string;
  ARTIST: string;
  ALBUM: string;
  YEAR: string;
  CIRCLE: string;
  DURATION: number;
  SONGSTART: Date;
  SONGEND: Date;
  SONGID: number;
  ALBUMID: number;
  RATING: number;
  TIMESRATED: number;
  LISTENERS: number;
  LASTUPDATE: string;
  ALBUMART: string | null;
  IN_WEEK: number;
  IN_MONTH: number;
  IN_YEAR: number;
  favorited_at: string | null;
}

interface GenApiResponseType {
  data: GenType[];
}

type FilterMode =
  | "recentHourly"
  | "recentDaily"
  | "recentMonthly"
  | "overallHourly"
  | "overallWeekly";
