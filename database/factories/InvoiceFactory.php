<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['sent','paid', 'late', 'cancelled']);
//        dd($status);
        return [
            'customer_name' => $this->faker->name(),
            'number' => $this->faker->numerify('FA-' . Carbon::today()->subDays(rand(0, 365))->format('Y-m') . '-###'),
            'status' => $status,
            'sent_at' => $this->faker->date(),
            'content' => $this->faker->text(),
            'paid_at' => ($status === 'paid') ? $this->faker->date() : null,
        ];
    }
}
