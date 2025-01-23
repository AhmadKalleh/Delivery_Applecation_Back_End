<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //public/storage/stores/photo_2025-01-15_09-00-39.jpg
        $apple_store = Store::query()->create([
            'name' =>'Apple Store',
            'image_path' => 'stores/photo_2025-01-15_09-00-39.jpg',
            'description' => 'A premium electronics store offering cutting-edge technology products, including iPhones, MacBooks, and accessories',
            'user_id' =>1
        ]);

        $nik_store = Store::query()->create([
            'name' =>'Nike Store',
            'image_path' => 'stores/Nike-Store.jpg',
            'description' => 'A leading sportswear retailer specializing in innovative and stylish athletic apparel, footwear, and accessories.',
            'user_id' =>1
        ]);

        $sephora_store = Store::query()->create([
            'name' =>'Sephora Store',
            'image_path' => 'stores/Sephora-store.jpg',
            'description' => 'A beauty retailer offering premium makeup, skincare, and fragrance products',
            'user_id' =>1
        ]);

        $shein_store = Store::query()->create([
            'name' =>'Shein Store',
            'image_path' => 'stores/Shein-Store.webp',
            'description' => 'Shein is an online fashion retailer offering trendy clothing, accessories, and beauty products at affordable prices.',
            'user_id' =>1
        ]);

        $amazon_store = Store::query()->create([
            'name' =>'Amazon Store',
            'image_path' => 'stores/Amazon-Store.jpg',
            'description' => 'Amazon is an e-commerce giant offering everything from electronics to groceries, known for its fast delivery and competitive prices',
            'user_id' =>1
        ]);
    }
}
