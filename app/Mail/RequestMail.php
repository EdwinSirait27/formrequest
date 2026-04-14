<?php

namespace App\Mail;
use App\Models\Formrequest;
use App\Models\Capextype;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class RequestMail extends Mailable implements ShouldQueue 
{
    use Queueable, SerializesModels;
    public $tries = 3;
    public $backoff = 60;
    public $timeout = 30;

    public Formrequest $formrequest;

    public function __construct(Formrequest $formrequest)
    {
        $this->formrequest = $formrequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Approval Request] ' . $this->formrequest->title,
        );
    }

    public function content(): Content
    {
        $formrequest = $this->formrequest->load([
            'items',
            'user',
            'links',
            'documenttype',
            'requesttype',
            'items.vendors',
            'items.vendors.vendor',
            'approval',
            'approval.approver1User.employee',
        ]);

        $capexpayreqVendors = $formrequest->items->mapWithKeys(function ($item) {
            return [
                $item->id => $item->vendors->values()->map(fn($v) => [
                    'vendor_name' => $v->vendor?->vendor_name ?? '-',
                    'price'       => $v->price ?? 0,
                ])
            ];
        });
        
$approval = $formrequest->approval;
$document_type_name = $formrequest->documenttype?->document_type_name ?? null;
$payment_type_payreq = $formrequest->payment_type_payreq;

$approver1 = $approval?->approver1User?->employee?->employee_name ?? 'Not Approved yet';

$approver1_at = $approval?->approver1_at 
    ? Carbon::parse($approval->approver1_at)->format('d M Y H:i:s') 
    : '-';
        $assetsOptions = Formrequest::getAssetOptions();
        return new Content(
            view: 'emails.request',
            with: [
                'formrequest' => $formrequest,
                'requestDate' => Carbon::parse($this->formrequest->request_date)->format('d M Y'),
                'assetsLabel' => $assetsOptions[$formrequest->assets] ?? '-',
                'deadline'    => Carbon::parse($this->formrequest->deadline)->format('d M Y'),
              'approver1' => $approver1,
'approver1_at' => $approver1_at,
                'capexpayreqVendors' => $capexpayreqVendors,
                'document_type_name' => $document_type_name,
                'payment_type_payreq' => $payment_type_payreq,
                'detailUrl'   => route('editrequest', [
                    'hash' => substr(hash('sha256', $this->formrequest->id . env('APP_KEY')), 0, 8)
                ]),
            ]
        );
    }
    public function attachments(): array
    {
        return [];
    }
}