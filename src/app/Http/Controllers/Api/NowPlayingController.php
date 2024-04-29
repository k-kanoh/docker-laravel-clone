<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NowPlayingService;

class NowPlayingController extends Controller
{
    private $service;

    public function __construct(NowPlayingService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->getNowPlayingList();

        return response()->json($data);
    }
}
