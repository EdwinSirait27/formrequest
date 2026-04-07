<?php

namespace App\Mail;
use App\Models\Formrequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
class RequestMail extends Mailable
{
    use Queueable, SerializesModels;

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
        'requesttype',
        'items.vendors',
        'items.vendors.vendor',
    ]);
    $capexVendors = $formrequest->items->mapWithKeys(function ($item) {
        return [
            $item->id => $item->vendors->values()->map(fn($v) => [
                'vendor_name' => $v->vendor?->vendor_name ?? '-',
                'price'       => $v->price ?? 0,
            ])
        ];
    });
        return new Content(
            view: 'emails.request',
            with: [
                'formrequest' => $this->formrequest->load(['items', 'user','links','items.vendors']),
                'requestDate' => Carbon::parse($this->formrequest->request_date)->format('d M Y'),
            'deadline' => Carbon::parse($this->formrequest->deadline)->format('d M Y'),
            'capexVendors' => $capexVendors,    
            'detailUrl' => route('editrequest', [
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