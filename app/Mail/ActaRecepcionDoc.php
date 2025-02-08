<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActaRecepcionDoc extends Mailable
{
    use Queueable, SerializesModels;

    public $dataRequiurements;
    public $dataApplicant;
    public $filename;
    public $segundoFilename;
    public $storagePath;
    public $storagePath2;

    /**
     * Create a new message instance.
     */
    public function __construct($dataRequiurements,
                                $dataApplicant,
                                $filename,
                                $segundoFilename,
                                $storagePath,
                                $storagePath2)
    {
        $this->dataRequiurements = $dataRequiurements;
        $this->dataApplicant = $dataApplicant;
        $this->filename = $filename;
        $this->segundoFilename = $segundoFilename;
        $this->storagePath = $storagePath;
        $this->storagePath2 = $storagePath2;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acta Recepcion Documentos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.acta-recepcion-doc',
            with: ['dataRequiurements' => $this->dataRequiurements,
                'dataApplicant' => $this->dataApplicant],
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
            Attachment::fromPath(storage_path('app/temp/' . $this->segundoFilename))  // Añade segunda ruta
            ->as($this->segundoFilename)
                ->withMime('application/pdf'),
        ];
    }
}
