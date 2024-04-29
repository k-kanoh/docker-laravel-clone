<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\RecordNotFoundException;
use App\Models\Gen;
use App\Repositories\Interfaces\IFavoriteRepository;

class FavoriteService
{
    private $repository;
    private $nowPlayingService;

    public function __construct(IFavoriteRepository $repository, NowPlayingService $nowPlayingService)
    {
        $this->repository = $repository;
        $this->nowPlayingService = $nowPlayingService;
    }

    public function storeFavorite($id)
    {
        $favorite = $this->repository->findByGenId($id);

        if ($favorite) {
            return response()->json(['message' => 'Favorite already exists.'], 409);
        }

        $gen = Gen::find($id);

        if (!$gen) {
            throw new RecordNotFoundException();
        }

        $this->repository->create($id, $gen->SONGID);

        $result = $this->nowPlayingService->getNowPlaying($id);

        return response()->json($result, 201);
    }

    public function destroyFavorite($id)
    {
        $deleted = $this->repository->deleteByGenId($id);

        if ($deleted) {
            $result = $this->nowPlayingService->getNowPlaying($id);

            return response()->json($result, 200);
        }

        return response()->json(['message' => 'Favorite not found.'], 404);
    }
}
