<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActaFichaTecnica extends Mailable
{
    use Queueable, SerializesModels;

    public $products, $requeriments, $messagesNotifications, $stateNotification;
    public $filename;

    /**
     * Create a new message instance.
     */
    public function __construct($products,
                                $requeriments,
                                $messagesNotifications,
                                $stateNotification,
                                $filename)
    {
        $this->products = $products;
        $this->requeriments = $requeriments;
        $this->messagesNotifications = $messagesNotifications;
        $this->stateNotification = $stateNotification;
        $this->filename = $filename;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acta Ficha Tecnica',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.notification-requeriment',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/temp/' . $this->filename))
                ->as($this->filename)
                ->withMime('application/pdf'),
        ];
    }
}
