import { ApiError } from "@/lib/errors/ApiError";

export const listenersApi = async (filterMode: FilterMode, date: Date) => {
  const response = await fetch(
    `/api/listeners?mode=${filterMode}&ymd=${date.toShortDateString()}`
  );

  if (response.ok) {
    const data: [] = await response.json();
    switch (filterMode) {
      case "recentDaily":
      case "recentMonthly":
        return data.slice(1).map((x, i) => ({
          name: (i + 1).toString(),
          listeners: parseInt(x),
        }));

      case "overallWeekly":
        return data.map((x, i) => ({
          name: ["日", "月", "火", "水", "木", "金", "土"][i] ?? "",
          listeners: parseInt(x),
        }));

      default:
        return data.map((x, i) => ({
          name: i.toString(),
          listeners: parseInt(x),
        }));
    }
  }

  throw await ApiError.fromResponse(response);
};
