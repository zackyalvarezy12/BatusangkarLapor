<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->unique()->word(),
            'slug' => $this->faker->slug(),
            'deskripsi' => $this->faker->sentence(),
            'urutan' => 0,
            'is_active' => true,
        ];
    }
}
