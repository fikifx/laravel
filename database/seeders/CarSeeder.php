<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        // Data dummy sama persis dengan defaultCars di landingpage/index.vue
        // Jika database kosong, frontend akan menampilkan data ini sebagai fallback
        // Jalankan: php artisan db:seed --class=CarSeeder

        $cars = [
            [
                'name'        => 'New Avanza',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'AT/MT',
                'year'        => 2022,
                'price_sopir' => 'Rp. 600.000',
                'price_lepas' => 'Rp. 350.000 /24 jam',
                'tag'         => 'Populer',
            ],
            [
                'name'        => 'New Innova Reborn',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'Matic',
                'year'        => 2023,
                'price_sopir' => 'Rp. 950.000 /12 jam',
                'price_lepas' => 'Rp. 750.000 /24 jam',
                'tag'         => null,
            ],
            [
                'name'        => 'Hiace Commuter',
                'image'       => null,
                'seats'       => 15,
                'transmission'=> 'Manual',
                'year'        => 2021,
                'price_sopir' => 'Rp. 1.100.000 /12 jam',
                'price_lepas' => null,
                'tag'         => 'Grup Besar',
            ],
            [
                'name'        => 'Pajero Sport',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'Matic',
                'year'        => 2023,
                'price_sopir' => 'Rp. 2.000.000',
                'price_lepas' => 'Rp. 1.700.000 /24 jam',
                'tag'         => null,
            ],
            [
                'name'        => 'New Innova Zenix',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'Hybrid/AT',
                'year'        => 2024,
                'price_sopir' => 'Rp. 1.200.000',
                'price_lepas' => 'Rp. 900.000 /24 jam',
                'tag'         => null,
            ],
            [
                'name'        => 'New Veloz',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'AT/MT',
                'year'        => 2024,
                'price_sopir' => 'Rp. 650.000',
                'price_lepas' => 'Rp. 400.000 /24 jam',
                'tag'         => null,
            ],
            [
                'name'        => 'Toyota Fortuner VRZ',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'Matic',
                'year'        => 2023,
                'price_sopir' => 'Rp. 1.800.000',
                'price_lepas' => 'Rp. 1.500.000 /24 jam',
                'tag'         => null,
            ],
            [
                'name'        => 'Hiace Premio',
                'image'       => null,
                'seats'       => 12,
                'transmission'=> 'AT',
                'year'        => 2022,
                'price_sopir' => 'Rp. 1.400.000 /12 jam',
                'price_lepas' => null,
                'tag'         => 'Kemewahan Grup',
            ],
            [
                'name'        => 'Toyota Alphard',
                'image'       => null,
                'seats'       => 7,
                'transmission'=> 'Matic',
                'year'        => 2022,
                'price_sopir' => 'Rp. 3.500.000 /12 jam',
                'price_lepas' => null,
                'tag'         => 'Premium',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
