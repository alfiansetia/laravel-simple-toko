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

        // $categories = ['Makanan', 'Minuman', 'Lain lain'];
        // foreach ($categories as $key => $value) {
        //     $cat = Category::create([
        //         'name'  => $value,
        //         'slug'  => fake()->slug(),
        //         // 'image' => 'https://picsum.photos/400/400?random=' . fake()->numberBetween(1000, 5000),
        //         // 'image' => fake()->imageUrl()
        //     ]);
        //     for ($i = 0; $i < 3; $i++) {
        //         $prod = Product::create([
        //             'category_id'   => $cat->id,
        //             'name'          => fake()->name(),
        //             'slug'          => fake()->slug(),
        //             // 'image'         => 'https://picsum.photos/400/400?random=' . fake()->numberBetween(1000, 5000),
        //             'price'         => fake()->numberBetween(1000, 1000000),
        //             'is_available'  => true,
        //             'description'   => fake()->sentence(),
        //         ]);
        //     }
        // }

        $categories = ['Makanan', 'Minuman', 'Lain-lain'];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        $products = [
            'Nasi Goreng',
            'Mie Ayam',
            'Es Teh Manis',
            'Jus Jeruk',
            'Susu Cokelat',
            'Roti Bakar',
            'Kopi Hitam',
            'Air Mineral',
            'Sate Ayam',
            'Keripik Kentang',
        ];

        $categories = Category::pluck('id', 'name');

        foreach ($products as $name) {
            if (collect(['Nasi', 'Mie', 'Roti', 'Sate', 'Keripik'])->contains(fn($x) => str_contains($name, $x))) {
                $categoryId = $categories['Makanan'];
            } elseif (collect(['Teh', 'Jus', 'Susu', 'Kopi', 'Air'])->contains(fn($x) => str_contains($name, $x))) {
                $categoryId = $categories['Minuman'];
            } else {
                $categoryId = $categories['Lain-lain'];
            }

            Product::create([
                'name'          => $name,
                'slug'          => Str::slug($name),
                'price'         => rand(5000, 20000),
                'category_id'   => $categoryId,
            ]);
        }
    }
}
