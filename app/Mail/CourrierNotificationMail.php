<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class CourrierNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $courrier;
    public $employee;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Courrier  $courrier
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function __construct($courrier, $employee)
    {
        $this->courrier = $courrier;
        $this->employee = $employee;
    }

    public function build()
    {
        return $this->view('emails.courrier_notification')
                    ->with([
                        'reference' => $this->courrier->reference,
                        'type' => $this->courrier->type,
                        'subject' => $this->courrier->subject,
                        'content' => $this->courrier->content,
                        'status' => $this->courrier->status,
                        'sender' => $this->courrier->sender,
                        'recipient' => $this->courrier->recipient,
                    ]);
    }
}