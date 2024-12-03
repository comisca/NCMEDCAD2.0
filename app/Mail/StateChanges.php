<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StateChanges extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $status, $messagess, $password, $email;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $status, $messagess, $password, $email)
    {
        $this->name = $name;
        $this->status = $status;
        $this->messagess = $messagess;
        $this->password = $password;
        $this->email = $email;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cambio de Estado',
//            cc: [new Address('cc@example.com', 'CC Recipient')],
//            bcc: [new Address('bcc@example.com', 'BCC Recipient')]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.states-changes',
            with: ['name' => $this->name,
                'status' => $this->status,
                'messagess' => $this->messagess,
                'password' => $this->password,
                'email' => $this->email],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
