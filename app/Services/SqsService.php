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
            'region'      => config('services.aws.region', 'ap-southeast-1'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);

        $this->queueUrl = config('services.aws.sqs_url');
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

    public function kirimSignPdf(string $s3Key, string $nomorSurat, string $verificationHash): void
{
    try {
        $result = $this->client->sendMessage([
            'QueueUrl'    => config('services.aws.pdf_sign_queue_url'),
            'MessageBody' => json_encode([
                'tipe'              => 'sign',
                's3_key'            => $s3Key,
                'nomor_surat'       => $nomorSurat,
                'verification_hash' => $verificationHash,
            ]),
        ]);

        Log::info('[SQS] Pesan sign berhasil dikirim', [
            'MessageId' => $result->get('MessageId'),
            's3_key'    => $s3Key,
        ]);

    } catch (\Exception $e) {
        Log::error('[SQS] Gagal kirim pesan sign: ' . $e->getMessage());
    }
}

}