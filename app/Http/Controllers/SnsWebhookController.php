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

        Log::info('[SNS Webhook] Masuk', ['type' => $type]);

        // ✅ Auto-konfirmasi subscription saat AWS kirim SubscriptionConfirmation
        if ($type === 'SubscriptionConfirmation') {
            $url = $payload['SubscribeURL'] ?? null;
            if ($url) {
                file_get_contents($url);
                Log::info('[SNS Webhook] Subscription dikonfirmasi');
            }
        }

        // ✅ Saat user klik konfirmasi di email, update sns_confirmed = true
        if ($type === 'Notification') {
            $endpoint = $payload['Endpoint'] ?? null;

            if ($endpoint) {
                User::where('email', $endpoint)
                    ->update(['sns_confirmed' => true]);

                Log::info('[SNS Webhook] sns_confirmed diupdate', ['email' => $endpoint]);
            }
        }

        return response()->json(['ok' => true]);
    }
}