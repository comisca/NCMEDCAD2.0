<?php

namespace App\Jobs;

use App\Models\Auctions;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Session;
use DB;

class CheckAutionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();

            $now = Carbon::now();

            // Buscar subastas que deberían haber terminado
            $auctions = Auctions::where('auction_state', '!=', 'Finalizada')
                ->whereRaw("CONCAT(date_start, ' ', hour_start) <= ?", [$now])
                ->get();

            foreach ($auctions as $auction) {
                $startTime = Carbon::parse($auction->date_start . ' ' . $auction->hour_start);
                $endTime = $startTime->copy()->addMinutes($auction->duration_time);

                if ($now->gt($endTime)) {
                    $auction->update([
                        'auction_state' => 'Finalizada',
                    ]);

                    \Log::info("Subasta {$auction->id} finalizada automáticamente");
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error("Error en CheckAuctionsStatus: " . $e->getMessage());
        }
    }
}
