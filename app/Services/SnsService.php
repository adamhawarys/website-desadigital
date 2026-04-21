<?php

namespace App\Services;

use Aws\Sns\SnsClient;
use Illuminate\Support\Facades\Log;

class SnsService
{
    protected SnsClient $client;
    protected string $topicArn;
    protected string $topicArnAdmin;

    public function __construct()
    {
        $this->client = new SnsClient([
            'region'  => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
            'version' => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $this->topicArn      = env('AWS_SNS_TOPIC_ARN');
        $this->topicArnAdmin = env('AWS_SNS_TOPIC_ARN_ADMIN');
    }

    // BROADCAST KE SEMUA WARGA (pengumuman/agenda desa)
    public function publishPengumuman(string $pesan, string $judul = 'Pengumuman Desa'): ?string
    {
        try {
            $result = $this->client->publish([
                'TopicArn' => $this->topicArn,
                'Subject'  => $judul,
                'Message'  => $pesan,
            ]);

            Log::info('[SNS] Pengumuman berhasil dikirim', [
                'MessageId' => $result->get('MessageId'),
                'judul'     => $judul,
            ]);

            return $result->get('MessageId');

        } catch (\Exception $e) {
            Log::error('[SNS] Gagal mengirim pengumuman: ' . $e->getMessage());
            return null;
        }
    }

    // DAFTARKAN EMAIL WARGA ke topic notifikasi-desa
    public function daftarkanEmail(string $email): ?string
    {
        try {
            $result = $this->client->subscribe([
                'TopicArn' => $this->topicArn,
                'Protocol' => 'email',
                'Endpoint' => $email,
            ]);

            Log::info('[SNS] Email warga didaftarkan', [
                'SubscriptionArn' => $result->get('SubscriptionArn'),
                'email'           => $email,
            ]);

            return $result->get('SubscriptionArn');

        } catch (\Exception $e) {
            Log::error('[SNS] Gagal mendaftarkan email warga: ' . $e->getMessage());
            return null;
        }
    }

    // DAFTARKAN EMAIL ADMIN ke topic notifikasi-admin
    public function daftarkanEmailAdmin(string $email): ?string
    {
        try {
            $result = $this->client->subscribe([
                'TopicArn' => $this->topicArnAdmin,
                'Protocol' => 'email',
                'Endpoint' => $email,
            ]);

            Log::info('[SNS] Email admin didaftarkan', [
                'SubscriptionArn' => $result->get('SubscriptionArn'),
                'email'           => $email,
            ]);

            return $result->get('SubscriptionArn');

        } catch (\Exception $e) {
            Log::error('[SNS] Gagal mendaftarkan email admin: ' . $e->getMessage());
            return null;
        }
    }
}