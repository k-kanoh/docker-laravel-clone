<?php declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\IGenListenersSummaryRepository;
use Illuminate\Support\Facades\DB;

class GenListenersSummaryRepository implements IGenListenersSummaryRepository
{
    public function getSummaryRecentHourly($ymd)
    {
        return DB::table(DB::raw('(
            SELECT
                ROUND(AVG(LISTENERS)) AS listeners,
                YEAR(LASTUPDATE) AS y,
                MONTH(LASTUPDATE) AS m,
                DAY(LASTUPDATE) AS d,
                HOUR(LASTUPDATE) AS h
            FROM
                gen
            GROUP BY
                YEAR(LASTUPDATE),
                MONTH(LASTUPDATE),
                DAY(LASTUPDATE),
                HOUR(LASTUPDATE)
        ) AS A'))
            ->where('y', substr($ymd, 0, 4))
            ->where('m', substr($ymd, 4, 2))
            ->where('d', substr($ymd, 6, 2))
            ->orderBy('h')
            ->get();
    }

    public function getSummaryRecentDaily($ymd)
    {
        return DB::table(DB::raw('(
            SELECT
                ROUND(AVG(LISTENERS)) AS listeners,
                YEAR(LASTUPDATE) AS y,
                MONTH(LASTUPDATE) AS m,
                DAY(LASTUPDATE) AS d
            FROM
                gen
            GROUP BY
                YEAR(LASTUPDATE),
                MONTH(LASTUPDATE),
                DAY(LASTUPDATE)
        ) AS A'))
            ->where('y', substr($ymd, 0, 4))
            ->where('m', substr($ymd, 4, 2))
            ->orderBy('d')
            ->get();
    }

    public function getSummaryRecentMonthly($ymd)
    {
        return DB::table(DB::raw('(
            SELECT
                ROUND(AVG(LISTENERS)) AS listeners,
                YEAR(LASTUPDATE) AS y,
                MONTH(LASTUPDATE) AS m
            FROM
                gen
            GROUP BY
                YEAR(LASTUPDATE),
                MONTH(LASTUPDATE)
        ) AS A'))
            ->where('y', substr($ymd, 0, 4))
            ->orderBy('m')
            ->get();
    }

    public function getSummaryOverallHourly()
    {
        return DB::table('gen')
            ->select(
                DB::raw('ROUND(AVG(LISTENERS)) AS listeners'),
                DB::raw('HOUR(LASTUPDATE) AS h')
            )
            ->groupBy(DB::raw('HOUR(LASTUPDATE)'))
            ->orderBy('h')
            ->pluck('listeners');
    }

    public function getSummaryOverallWeekly()
    {
        return DB::table('gen')
            ->select(
                DB::raw('ROUND(AVG(LISTENERS)) AS listeners'),
                DB::raw('DAYOFWEEK(LASTUPDATE) AS w')
            )
            ->groupBy(DB::raw('DAYOFWEEK(LASTUPDATE)'))
            ->orderBy('w')
            ->pluck('listeners');
    }
}
