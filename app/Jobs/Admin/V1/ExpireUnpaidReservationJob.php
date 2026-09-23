<?php

namespace App\Jobs\Admin\V1;

use App\Models\Reservation;
use App\Service\Ghasedak\smsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PHPUnit\Event\Code\Throwable;
use function Illuminate\Support\minutes;

class ExpireUnpaidReservationJob implements ShouldQueue
{
    public $tries=3;
    use Queueable;
    public function __construct(public Reservation $reservation,public $phone)
    {
        //
    }
    public function handle(smsService $service): void
    {
        if ($this->reservation->status == 'completed' ||
            $this->reservation->status == 'cancelled'
        ) {return;}

        if ($this->reservation->olderThen(minutes: 5)){
            $service->send(
                $this->phone,
                'این پیامک جهت تست وب سرویس لاراولی میباشد'
            );
        }
        if ($this->reservation->olderThen(minutes: 10)){
            $this->reservation->cancel();
            return;
        }
        $this->release(now()->addMinute(10));
    }

    public function failed(\Throwable $exception): void
    {
        Log::error($exception->getMessage());
    }
}
