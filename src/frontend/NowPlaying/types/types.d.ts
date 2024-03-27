interface GenType {
  TITLE: string;
  ARTIST: string;
  ALBUM: string;
  YEAR: string;
  CIRCLE: string;
  DURATION: number;
  SONGEND: Date;
  RATING: number;
  ALBUMART: string | null;
  IN_WEEK: number;
  IN_MONTH: number;
  IN_YEAR: number;
}

interface GenApiResponseType {
  data: GenType[];
}

interface ScrollableContainerRefProps {
  scrollableContainerRef: React.RefObject<HTMLDivElement>;
}

interface PaginationProps {
  page: number;
  setPage: React.Dispatch<React.SetStateAction<number>>;
}
