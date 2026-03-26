<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;

class RequestMail extends Mailable
{
    use Queueable, SerializesModels;
   public $employee;
    /**
     * Create a new message instance.
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }
    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Form Request - Asian Bay Development')
                    ->view('emails.request', [
                        'employee' => $this->employee,
                        'department' => $this->employee->department,
                        'position' => $this->employee->position,
                        'company' => $this->employee->company,
                        'store' => $this->employee->store,
                    ]);
    }
}
