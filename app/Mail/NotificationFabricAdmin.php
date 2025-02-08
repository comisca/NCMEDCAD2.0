<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationFabricAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $nameD, $nameF;

    /**
     * Create a new message instance.
     */
    public function __construct($nameD, $nameF)
    {
        $this->nameD = $nameD;
        $this->nameF = $nameF;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notification Fabricante con multiples Aplicaciones',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.notification-fabric-admin',
            with: ['nameD' => $this->nameD,
                'nameF' => $this->nameF],
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
