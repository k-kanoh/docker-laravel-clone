<?php declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface INowPlayingRepository
{
    public function getNowPlayingList();

    public function getNowPlaying($id);
}
