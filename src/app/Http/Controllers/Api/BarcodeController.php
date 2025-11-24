<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarcodeSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarcodeController extends Controller
{
    public function createSession(Request $request) : JsonResponse
    {
        $sessionId = Str::uuid()->toString();

        $session = BarcodeSession::create([
            'session_id' => $sessionId,
            'create_ip' => $request->ip(),
            'create_host' => gethostbyaddr($request->ip()),
        ]);

        return response()->json(['id' => $session->session_id], 201);
    }

    public function scan(Request $request, string $sessionId) : JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:500',
        ]);

        $session = BarcodeSession::where('session_id', $sessionId)->first();

        if (!$session) {
            return response()->json(['message' => 'セッションが見つかりません'], 400);
        }

        $session->addScannedData(
            $validated['text'],
            $request->ip(),
            gethostbyaddr($request->ip())
        );

        return response()->json(['success' => true]);
    }

    public function clear(string $sessionId) : JsonResponse
    {
        $session = BarcodeSession::where('session_id', $sessionId)->first();

        if (!$session) {
            return response()->json(['message' => 'セッションが見つかりません'], 400);
        }

        $session->clearScannedData();

        return response()->json(['success' => true]);
    }

    public function poll(string $sessionId) : JsonResponse
    {
        $session = BarcodeSession::where('session_id', $sessionId)->first();

        if (!$session) {
            return response()->json(['message' => 'セッションが見つかりません'], 400);
        }

        return response()->json([
            'id' => $session->session_id,
            'data' => $session->scanned_data,
        ]);
    }
}
