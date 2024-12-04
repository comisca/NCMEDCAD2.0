<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationRequeriment extends Mailable
{
    use Queueable, SerializesModels;

    public $products, $requeriments, $messagesNotifications, $stateNotification;

    /**
     * Create a new message instance.
     */
    public function __construct($products, $requeriments, $messagesNotifications, $stateNotification)
    {
        $this->products = $products;
        $this->requeriments = $requeriments;
        $this->messagesNotifications = $messagesNotifications;
        $this->stateNotification = $stateNotification;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Observaciones de requerimientos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.notification-requeriment',
            with: [
                'products' => $this->products,
                'requeriments' => $this->requeriments,
                'messagesNotifications' => $this->messagesNotifications,
                'stateNotification' => $this->stateNotification
            ],
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
