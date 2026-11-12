<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@demplane.com'],
            [
                'name' => 'Admin Demplane',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081122334455',
                'address' => 'Jl. Demplane Admin No. 1, Jakarta',
            ]
        );

        // 2. Create Regular Users
        $user1 = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller Active',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '08111222333',
                'address' => 'Jl. Seller User No. 42, Bandung',
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Buyer Happy',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '08998887776',
                'address' => 'Jl. Pembeli Makmur No. 99, Surabaya',
            ]
        );

        // 3. Create Categories
        $categories = [
            ['name' => 'Pakaian Wanita', 'slug' => 'pakaian-wanita'],
            ['name' => 'Pakaian Pria', 'slug' => 'pakaian-pria'],
            ['name' => 'Vintage', 'slug' => 'vintage'],
            ['name' => 'Streetwear', 'slug' => 'streetwear'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $cats = Category::all();

        // 4. Create dummy products
        if (Product::count() === 0) {
            $products = [
                [
                    'name' => 'Vintage Denim Jacket Levi\'s',
                    'category' => 'vintage',
                    'price' => 350000,
                    'condition' => 'good',
                    'size' => 'L',
                    'brand' => 'Levi\'s',
                    'description' => 'Jaket denim vintage asli tahun 90-an. Kondisi sangat terawat, patina alami yang keren. Cocok untuk gaya retro.',
                ],
                [
                    'name' => 'Oversized Graphic Tee',
                    'category' => 'streetwear',
                    'price' => 120000,
                    'condition' => 'like_new',
                    'size' => 'XL',
                    'brand' => 'Uniqlo',
                    'description' => 'Kaos oversized dengan sablon grafis aesthetic. Baru dipakai 2 kali, kondisi seperti baru.',
                ],
                [
                    'name' => 'Blouse Floral Summer',
                    'category' => 'pakaian-wanita',
                    'price' => 85000,
                    'condition' => 'good',
                    'size' => 'M',
                    'brand' => 'H&M',
                    'description' => 'Blouse motif floral elegan, bahan adem banget buat dipakai pas musim panas atau liburan.',
                ],
                [
                    'name' => 'Kemeja Flannel Kotak-Kotak',
                    'category' => 'pakaian-pria',
                    'price' => 95000,
                    'condition' => 'fair',
                    'size' => 'L',
                    'brand' => 'Zara',
                    'description' => 'Kemeja flannel tebal yang cozy. Ada sedikit minus warna pudar di kerah tapi masih sangat layak pakai.',
                ]
            ];

            foreach ($products as $p) {
                $category = $cats->where('slug', $p['category'])->first();

                Product::create([
                    'user_id' => $user1->id,
                    'category_id' => $category->id,
                    'name' => $p['name'],
                    'slug' => Str::slug($p['name']) . '-' . Str::random(4),
                    'description' => $p['description'],
                    'price' => $p['price'],
                    'condition' => $p['condition'],
                    'size' => $p['size'],
                    'brand' => $p['brand'],
                    'stock' => 1,
                    'is_active' => true,
                    'views' => rand(10, 100),
                ]);
            }
        }
    }
}
