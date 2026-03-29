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
        return new Content(
            view: 'emails.request',
            with: [
                'formrequest' => $this->formrequest->load(['items', 'user']),
                'requestDate' => Carbon::parse($this->formrequest->request_date)->format('d M Y'),
            'deadline' => Carbon::parse($this->formrequest->deadline)->format('d M Y'),
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