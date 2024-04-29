<?php declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface IFavoriteRepository
{
    public function findByGenId($genId);

    public function create($genId, $songId);

    public function deleteByGenId($genId);
}
