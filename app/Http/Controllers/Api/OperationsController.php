<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OperationsController extends Controller
{
    public function status(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'timestamp' => now()->toIso8601String(),
            'user' => [
                'id' => $request->user()->id,
                'email' => $request->user()->email,
                'roles' => $request->user()->getRoleNames(),
                'permissions' => $request->user()->getAllPermissions()->pluck('name'),
            ],
            'system_health' => 'OK',
        ]);
    }

    public function execute(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|string',
            'payload' => 'nullable|array',
        ]);

        if (!$request->user()->can('execute operations')) {
            return response()->json([
                'status' => 'forbidden',
                'message' => 'Akses ditolak: Anda tidak memiliki izin execute operations.',
            ], 403);
        }

        return response()->json([
            'status' => 'executed',
            'action' => $request->action,
            'processed_at' => now()->toIso8601String(),
            'executed_by' => $request->user()->email,
        ]);
    }
}