<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NowPlaying;

class NowPlayingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $summaris = NowPlaying::paginate(10);

        return response()->json($summaris);
    }
}
