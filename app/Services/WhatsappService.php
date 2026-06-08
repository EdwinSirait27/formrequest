<?php

// namespace App\Services;

// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

// class WhatsappService
// {
//     protected string $botUrl;
//     protected string $groupId;

//     public function __construct()
//     {
//         $this->botUrl  = config('services.whatsapp.bot_url');
//         $this->groupId = config('services.whatsapp.group_id');
//     }

//     public function sendGroup(string $message): void
//     {
//          if (!config('services.whatsapp.enabled') || !$this->groupId) {
//         Log::warning('WhatsApp not enabled or group_id not configured');
//         return;
//     }

//         try {
//             $response = Http::timeout(10)->post("{$this->botUrl}/send-message", [
//                 'group_id' => $this->groupId,
//                 'text'     => $message,
//             ]);

//             if (!$response->successful()) {
//                 Log::warning('WhatsApp send failed', [
//                     'status'   => $response->status(),
//                     'response' => $response->body(),
//                 ]);
//             }
//         } catch (\Throwable $e) {
//             Log::error('WhatsApp error: ' . $e->getMessage());
//         }
//     }
//     public function notifyRequestStatus(string $status, $formrequest): void
// {
//     $requester  = $formrequest->user?->employee?->employee_name ?? '-';
//     $title      = $formrequest->title ?? '-';
//     $docNumber  = $formrequest->document_number ?? '-';
//     $type       = $formrequest->requesttype?->request_type_name ?? '-';
//     $url        = route('editrequest', [
//         'hash' => substr(hash('sha256', $formrequest->id . config('app.key')), 0, 8)
//     ]);

//     $statusEmoji = [
//         'Submitted'         => '📋',
//         'Approved Manager'  => '✅',
//         'Rejected Manager'  => '❌',
//         'Approved BD'       => '✅',
//         'Rejected BD'       => '❌',
//         'Approved IT'       => '✅',
//         'Rejected IT'       => '❌',
//         'Approved GA'       => '✅',
//         'Rejected GA'       => '❌',
//         'Approved Director' => '✅',
//         'Rejected Director' => '❌',
//     ];

//     $emoji = $statusEmoji[$status] ?? '🔔';

//     $message = "{$emoji} *Form Request Update*\n\n"
//         . "📄 *{$type}*\n"
//         . "No. Dokumen : {$docNumber}\n"
//         . "Judul       : {$title}\n"
//         . "Pemohon     : {$requester}\n"
//         . "Status      : *{$status}*\n\n"
//         . " {$url}";

//     $this->sendGroup($message);
// }
// }

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected string $botUrl;
    protected ?string $groupId;

    public function __construct()
    {
        $this->botUrl  = config('services.whatsapp.bot_url');
        $this->groupId = config('services.whatsapp.group_id');
    }

    public function sendGroup(string $message): void
    {
        if (!config('services.whatsapp.enabled') || !$this->groupId) {
            Log::warning('WhatsApp not enabled or group_id not set');
            return;
        }

        try {
            $response = Http::timeout(10)->post("{$this->botUrl}/send-message", [
                'group_id' => $this->groupId,
                'text'     => $message,
            ]);

            if (!$response->successful()) {
                Log::warning('WA gagal kirim', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('WA error: ' . $e->getMessage());
        }
    }

    public function notifyRequestStatus(string $status, $formrequest): void
    {
        $requester  = $formrequest->user?->employee?->employee_name ?? '-';
        $title      = $formrequest->title ?? '-';
        $docNumber  = $formrequest->document_number ?? '-';
        $type       = $formrequest->requesttype?->request_type_name ?? '-';
        $isPR       = $formrequest->requesttype?->code === 'PR';
        $url        = route('editrequest', [
            'hash' => substr(hash('sha256', $formrequest->id . config('app.key')), 0, 8)
        ]);

        $isApproved = str_starts_with($status, 'Approved');
        $isRejected = str_starts_with($status, 'Rejected');
        $icon       = $isApproved ? '✅' : ($isRejected ? '❌' : '📋');

        // Siapa yang approve/reject
        $approval   = $formrequest->approval;
        $actor      = match(true) {
            $status === 'Submitted'                          => $requester,
            in_array($status, ['Approved Manager',
                'Rejected Manager'])                         => $approval?->approver1User?->employee?->employee_name ?? '-',
            in_array($status, ['Approved Director',
                'Rejected Director'])                        => $approval?->approver2User?->employee?->employee_name ?? '-',
            in_array($status, ['Approved GA',
                'Rejected GA'])                              => $approval?->prApprover?->employee?->employee_name ?? '-',
            in_array($status, ['Approved IT', 'Rejected IT',
                'Approved BD', 'Rejected BD'])               => $approval?->capexApprover?->employee?->employee_name ?? '-',
            default                                          => '-',
        };

        $actorLabel = match(true) {
            $status === 'Submitted'                              => 'Diajukan oleh',
            in_array($status, ['Approved Manager',
                'Rejected Manager'])                             => 'Manager',
            in_array($status, ['Approved Director',
                'Rejected Director'])                            => 'Director',
            in_array($status, ['Approved GA', 'Rejected GA'])   => 'GA',
            in_array($status, ['Approved IT', 'Rejected IT'])   => 'PIC IT',
            in_array($status, ['Approved BD', 'Rejected BD'])   => 'PIC BD',
            default                                              => 'Oleh',
        };

        $lines   = [];
        $lines[] = "{$icon} *[{$type}] {$status}*";
        $lines[] = "";
        $lines[] = "No. Dok  : {$docNumber}";
        $lines[] = "Judul    : {$title}";
        $lines[] = "Pemohon  : {$requester}";
        $lines[] = "Tgl Req  : " . ($formrequest->request_date?->translatedFormat('d F Y') ?? '-');
$lines[] = "Deadline : " . ($formrequest->deadline?->translatedFormat('d F Y') ?? '-');
        $lines[] = "{$actorLabel} : {$actor}";

        // Tambahan info khusus PR saat Approved GA
        if ($isPR && $status === 'Approved GA') {
            $store = $formrequest->store?->name ?? '-';
            $lines[] = "Lokasi   : {$store}";
        }

        // Catatan jika ada
        $notes = match(true) {
            str_contains($status, 'Manager')  => $formrequest->notes ?? null,
            str_contains($status, 'Director') => $formrequest->notes_dir ?? null,
            str_contains($status, 'GA')       => $formrequest->notes_ga ?? null,
            default                           => null,
        };

        if ($notes) {
            $lines[] = "Catatan  : {$notes}";
        }

        $lines[] = "";
        $lines[] = $url;

        $this->sendGroup(implode("\n", $lines));
    }
}