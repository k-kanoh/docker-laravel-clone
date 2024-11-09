import { ResponsiveBar } from "@nivo/bar";
import { useTheme } from "@/components/DarkMode/theme-provider";

export function ListenersChart({
  data,
}: {
  data: { name: string; listeners: number }[];
}) {
  const { textcolor } = useTheme();
  const axisBottomDisp = (value: string) => {
    if (data.length > 23 && /^\d+$/.test(value)) {
      return (Number(value) + Number(data[0]?.name)) % 2 === 0 ? value : "";
    }

    return value;
  };

  const labelCaption = () => {
    switch (data.length) {
      case 7:
        return "曜日";
      case 12:
        return "月";
      case 24:
        return "時";
      default:
        return "日";
    }
  };

  return (
    <div className="size-full">
      <ResponsiveBar
        axisBottom={{
          tickSize: 0,
          tickPadding: 4,
          format: axisBottomDisp,
        }}
        axisLeft={{
          tickSize: 0,
          tickValues: 1,
          tickPadding: 4,
        }}
        colors={["#16A34A"]}
        data={data}
        enableLabel
        gridYValues={9}
        indexBy="name"
        keys={["listeners"]}
        labelSkipHeight={1}
        margin={{ top: 20, right: 10, bottom: 23, left: 23 }}
        maxValue={80}
        padding={0.2}
        role="application"
        theme={{
          axis: { ticks: { text: { fontSize: "10px" } } },
          text: { fontSize: "7px", fill: `${textcolor}` },
          tooltip: {
            chip: {
              borderRadius: "50%",
            },
            container: {
              fontSize: "12px",
              borderRadius: "6px",
              color: "black",
            },
          },
          grid: {
            line: {
              stroke: "#f3f4f6",
            },
          },
        }}
        tooltipLabel={({ indexValue }) => `${indexValue}${labelCaption()}`}
      />
    </div>
  );
}
