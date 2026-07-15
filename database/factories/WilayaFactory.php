<?php

namespace Database\Factories;

use App\Models\Wilaya;
use Illuminate\Database\Eloquent\Factories\Factory;

class WilayaFactory extends Factory
{
    protected $model = Wilaya::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->unique()->city(),
            'slug' => $this->faker->slug(),
            'tipe' => 'kecamatan',
            'parent_id' => null,
            'is_active' => true,
        ];
    }
}
