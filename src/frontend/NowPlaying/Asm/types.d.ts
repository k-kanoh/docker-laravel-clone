interface GenType {
  TITLE: string;
  ARTIST: string;
  ALBUM: string;
  YEAR: number;
  CIRCLE: string;
  DURATION: string;
  SONGEND: Date;
  RATING: number;
  IN_WEEK: number;
  IN_MONTH: number;
  IN_YEAR: number;
  ALBUMART: string;
}

interface GenApiResponseType {
  current_page: number;
  data: GenType[];
  last_page: number;
  total: number;
}
