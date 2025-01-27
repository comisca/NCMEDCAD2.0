{{--<div class="col-md-4">--}}
{{--    <div class="card">--}}
{{--        <div class="d-flex justify-content-center">--}}
{{--            <div class="progress-circle" id="progress-circle">--}}
{{--                <div class="circle">--}}
{{--                    <span id="time-display" class="time-display">3:00</span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<div>
    <div x-data="timer()" x-init="startTimer()" wire:ignore>
        <div class="countdown" :class="{ 'text-danger': isRecoveryPeriod }">
            <span x-text="formatTime(remainingTime)"></span>
        </div>

        <template x-if="isRecoveryPeriod">
            <div class="alert alert-warning">
                ¡Período de recuperación activo! Cualquier puja reiniciará el contador a {{ $auction->recovery_time }}
                minutos.
            </div>
        </template>
    </div>
</div>
