<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        // 1. Logic for Titles
        $adjectives = ['Premium', 'Wireless', 'Ergonomic', 'Smart', 'Ultra', 'Pro', 'Classic', 'Portable'];
        $items = ['Headphones', 'Smartwatch', 'Mechanical Keyboard', 'Gaming Mouse', 'Laptop Stand', 'USB-C Hub', 'Backpack', 'Power Bank'];

        $title = fake()->randomElement($adjectives) . ' ' . fake()->randomElement($items);

        // 2. Logic for Structured Descriptions
        $features = [
            'features a sleek, modern design',
            'comes with long-lasting battery life',
            'is built with high-quality sustainable materials',
            'offers seamless connectivity with all your devices',
            'includes an industry-leading warranty',
            'is engineered for maximum performance and comfort'
        ];

        $benefits = [
            'perfect for daily commuting and travel.',
            'designed specifically for modern professionals.',
            'an essential tool for any home office setup.',
            'the ideal gift for tech enthusiasts.',
            'built to withstand the rigors of heavy daily use.'
        ];

        // Combine elements into a realistic paragraph
        $description = "This " . strtolower($title) . " " . fake()->randomElement($features) . ". It is " . fake()->randomElement($benefits);

        return [
            'title'       => $title,
            'description' => $description,
            'price'       => fake()->randomFloat(2, 20, 1500),
            'discount'    => fake()->randomElement([0, 0, 10, 15, 20, 50]),
            'image_url'   => 'https://picsum.photos/seed/' . fake()->uuid . '/640/480',
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
