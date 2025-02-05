<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationActas extends Mailable
{
    use Queueable, SerializesModels;

    public $viewData;
    protected $pdfPath;
    protected $filename;

    /**
     * Create a new message instance.
     */
    public function __construct($viewData, $pdfPath, $filename)
    {
        $this->viewData = $viewData;
        $this->pdfPath = $pdfPath;
        $this->filename = $filename;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acta de Subasta - ' . $this->viewData['actaData']->event_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.notification-actas',
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
