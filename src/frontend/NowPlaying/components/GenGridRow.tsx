import { TableRow, TableCell } from "@/components/ui/table";

export function GenGridRow({ param }: { param: GenType }) {
  return (
    <TableRow>
      <TableCell className="size-20">
        {/* <img
          alt="Product image"
          className="aspect-square rounded-md object-cover"
          height="64"
          src=""
          width="64"
        /> */}
      </TableCell>
      <TableCell>{param.TITLE}</TableCell>
      <TableCell>{param.ARTIST}</TableCell>
      <TableCell>{param.ALBUM}</TableCell>
      <TableCell className="text-center">{param.YEAR}</TableCell>
      <TableCell>{param.CIRCLE}</TableCell>
      <TableCell className="text-center">{param.DURATION}</TableCell>
      <TableCell className="text-nowrap">{param.SONGEND.toString()}</TableCell>
      <TableCell className="text-center">{param.RATING}</TableCell>
      <TableCell className="text-center">{param.IN_WEEK}</TableCell>
      <TableCell className="text-center">{param.IN_MONTH}</TableCell>
      <TableCell className="text-center">{param.IN_YEAR}</TableCell>
    </TableRow>
  );
}
