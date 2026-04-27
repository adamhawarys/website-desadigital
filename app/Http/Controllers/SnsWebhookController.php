<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SnsWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $type    = $payload['Type'] ?? null;

        Log::info('[SNS] payload masuk', ['type' => $type]);

        if ($type === 'SubscriptionConfirmation') {
            $url      = $payload['SubscribeURL'] ?? null;
            $endpoint = $payload['Endpoint'] ?? null;

            if ($url) {
                file_get_contents($url);
                Log::info('[SNS] subscription berhasil dikonfirmasi ke AWS');
            }

            if ($endpoint) {
                User::where('email', $endpoint)
                    ->update(['sns_confirmed' => true]);

                Log::info('[SNS] sns_confirmed diupdate', ['email' => $endpoint]);
            }
        }

        return response()->json(['ok' => true]);
    }
}