<?php

namespace App\Http\Transformers;

use App\Models\Reservation;

class ReservationTransformer
{
    public static function toInstance(array $input, $reservation = null)
    {
        if (empty($reservation)) {
            $reservation = new Reservation();
        }

        foreach ($input as $key => $value) {
            switch ($key) {
                case 'reserve_date':
                    $reservation->reserve_date = $value;
                    break;
                case 'guests':
                    $reservation->guests = $value;
                    break;
                case 'package_id':
                    $reservation->package_id = $value;
                    break;
            }
        }

        return $reservation;
    }
}
