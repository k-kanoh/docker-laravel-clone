<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\INowPlayingRepository;

class NowPlayingService
{
    private $repository;

    public function __construct(INowPlayingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNowPlayingList($favorited_only)
    {
        if ($favorited_only) {
            return $this->repository->getNowPlayingListFavoritedOnly();
        }

        return $this->repository->getNowPlayingList();
    }

    public function getNowPlaying($id)
    {
        return $this->repository->getNowPlaying($id);
    }
}
