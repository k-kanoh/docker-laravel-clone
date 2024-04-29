<?php declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Favorite;
use App\Repositories\Interfaces\IFavoriteRepository;

class FavoriteRepository implements IFavoriteRepository
{
    public function findByGenId($genId)
    {
        return Favorite::withoutTrashed()->where('gen_id', $genId)->first();
    }

    public function create($genId, $songId)
    {
        $favorite = new Favorite();
        $favorite->gen_id = $genId;
        $favorite->song_id = $songId;
        $favorite->save();
    }

    public function deleteByGenId($genId)
    {
        return Favorite::withoutTrashed()->where('gen_id', $genId)->delete();
    }
}
