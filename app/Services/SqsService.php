<?php

namespace App\Services;

use Aws\Sqs\SqsClient;
use Illuminate\Support\Facades\Log;

class SqsService
{
    protected SqsClient $client;
    protected string $queueUrl;

    public function __construct()
    {
        $this->client = new SqsClient([
            'region'      => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $this->queueUrl = env('AWS_SQS_URL');
    }

    /**
     * Kirim pesan notifikasi ke SQS
     * Pesan akan diproses oleh queue worker dan diteruskan ke SNS
     */
    public function kirimPesan(string $judul, string $pesan, ?string $email = null,string $tipe = 'personal'): ?string
    {
        try {
            $result = $this->client->sendMessage([
                'QueueUrl'    => $this->queueUrl,
                'MessageBody' => json_encode([
                    'judul' => $judul,
                    'pesan' => $pesan,
                    'email' => $email, 
                    'tipe'  => $tipe,
                    'waktu' => now()->format('d-m-Y H:i'),
                ]),
            ]);

            Log::info('[SQS] Pesan berhasil dikirim ke antrian', [
                'MessageId' => $result->get('MessageId'),
                'judul'     => $judul,
                'email'     => $email,
            ]);

            return $result->get('MessageId');

        } catch (\Exception $e) {
            Log::error('[SQS] Gagal mengirim pesan: ' . $e->getMessage());
            return null;
        }
    }


}