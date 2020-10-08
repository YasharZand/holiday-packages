<?php

namespace App\Http\Transformers;

use App\Models\Package;

class PackageTransformer
{
    public static function toInstance(array $input, $package = null)
    {
        if (empty($package)) {
            $package = new Package();
        }

        foreach ($input as $key => $value) {
            switch ($key) {
                case 'name':
                    $package->name = $value;
                    break;
                case 'hotel_name':
                    $package->hotel_name = $value;
                    break;
                case 'hotel_url':
                    $package->hotel_url = $value;
                    break;
                case 'duration':
                    $package->duration = $value;
                    break;
                case 'package_start_date':
                    $package->package_start_date = $value;
                    break;
                case 'validity':
                    $package->validity = $value;
                    break;
                case 'hotel_star':
                    $package->hotel_star = $value;
                    break;
                case 'price':
                    $package->price = $value;
                    break;
                case 'quantity':
                    $package->quantity = $value;
                    break;
            }
        }

        return $package;
    }
}
