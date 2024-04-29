<?php declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\INowPlayingRepository;
use Illuminate\Support\Facades\DB;

class NowPlayingRepository implements INowPlayingRepository
{
    public function getNowPlayingList()
    {
        return $this->getNowPlayingQuery()
            ->orderByDesc('G.ID')
            ->paginate(10);
    }

    public function getNowPlaying($id)
    {
        return $this->getNowPlayingQuery()
            ->where('G.ID', $id)
            ->first();
    }

    private function getNowPlayingQuery()
    {
        $subQuery1 = DB::table('gen')
            ->whereColumn('SONGID', 'G.SONGID')
            ->whereRaw('LASTUPDATE > (NOW() - INTERVAL 1 WEEK)')
            ->selectRaw('COUNT(*)');

        $subQuery2 = DB::table('gen')
            ->whereColumn('SONGID', 'G.SONGID')
            ->whereRaw('LASTUPDATE > (NOW() - INTERVAL 1 MONTH)')
            ->selectRaw('COUNT(*)');

        $subQuery3 = DB::table('gen')
            ->whereColumn('SONGID', 'G.SONGID')
            ->whereRaw('LASTUPDATE > (NOW() - INTERVAL 1 YEAR)')
            ->selectRaw('COUNT(*)');

        return DB::table('gen AS G')
            ->select(
                'G.*',
                DB::raw('(' . $subQuery1->toSql() . ') AS IN_WEEK'),
                DB::raw('(' . $subQuery2->toSql() . ') AS IN_MONTH'),
                DB::raw('(' . $subQuery3->toSql() . ') AS IN_YEAR'),
                'F.created_at AS favorited_at'
            )
            ->leftJoin('favorites AS F', function($join) {
                $join->on('G.ID', '=', 'F.gen_id')
                    ->whereNull('F.deleted_at');
            });
    }
}
