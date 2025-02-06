<?php

namespace App\Jobs;

use App\Mail\NotificationActas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendBulkActaEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $viewData;
    protected $filename;
    protected $emailssolos;
    public $batch_size = 5; // Procesar de 5 en 5

    /**
     * Create a new job instance.
     */
    public function __construct($viewData, $filename, array $emailssolos)
    {
        $this->viewData = $viewData;
        $this->filename = $filename;
        $this->emailssolos = $emailssolos;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        foreach (array_chunk($this->emailssolos, $this->batch_size) as $emailBatch) {
            foreach ($emailBatch as $email) {
                try {


                    // Envía el correo con el PDF adjunto
                    Mail::to($email)->send(
                        new NotificationActas(
                            $this->viewData,
                            storage_path('app/temp/' . $this->filename),
                            $this->filename
                        ));
                    sleep(2); // Pequeña pausa entre emails

                } catch (\Exception $e) {
                    \Log::error("Error enviando email a {$email}: " . $e->getMessage());
                    continue;
                    // Log::error('Error al enviar el correo: ' . $e->getMessage());
                }

            }
            sleep(5); // Pausa entre lotes
        }

        // Limpiamos el archivo temporal después de enviar todos los correos
        Storage::disk('local')->delete('temp/' . $this->filename);
    }
}
