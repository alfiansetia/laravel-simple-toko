<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'      => 'Admin',
            'role'      => 'admin',
            'password'  => Hash::make('admin12345'),
            'whatsapp'  => '082323424565'
        ]);

        User::factory()->create([
            'name'      => 'User Test',
            'password'  => Hash::make('user12345'),
            'whatsapp'  => '082323424564'
        ]);

        $categories = ['Makanan', 'Minuman', 'Lain lain'];
        foreach ($categories as $key => $value) {
            Category::create([
                'name'  => $value,
                'slug'  => fake()->slug(),
                'image' => 'https://picsum.photos/400/400?random=' . fake()->numberBetween(1000, 5000),
                // 'image' => fake()->imageUrl()
            ]);
        }

        $cat = Category::all();

        for ($i = 0; $i < 20; $i++) {
            $prod = Product::create([
                'category_id'   => $cat->random()->id,
                'name'          => fake()->name(),
                'slug'          => fake()->slug(),
                'image'         => 'https://picsum.photos/400/400?random=' . fake()->numberBetween(1000, 5000),
                'price'         => fake()->numberBetween(1000, 1000000),
                'stock'         => fake()->numberBetween(10, 100),
                'is_available'  => true,
                'description'   => fake()->sentence(),
            ]);
        }
    }
}
