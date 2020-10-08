<?php

namespace Tests\Feature;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PackageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_a_package() {

        // make an instance of the Employee Factory
        $package = Package::factory()->make([
            'hotel_star' => 1
        ]);

        // post the data to the packages store method
        $response = $this->post(route('packages.store'), [
            'name' => $package->name,
            'hotel_name' => $package->hotel_name,
            'hotel_url' => $package->hotel_url,
            'duration' => $package->duration,
            'package_start_date' => $package->package_start_date,
            'validity' => $package->validity,
            'hotel_star' => $package->hotel_star,
            'price' => $package->price,
            'quantity' => $package->quantity
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('packages', [
            'name' => $package->name,
            'hotel_name' => $package->hotel_name,
            'hotel_url' => $package->hotel_url,
            'duration' => $package->duration,
            'package_start_date' => $package->package_start_date,
            'validity' => $package->validity,
            'hotel_star' => $package->hotel_star,
            'price' => $package->price,
            'quantity' => $package->quantity
        ]);

    }
}
