<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function uploadeImages($products)
    {
        foreach($products as $product)
        {
            $new_product = Product::query()->create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'store_id' => $product['store_id'],
            ]);

            foreach($product['images'] as $index => $imagePath)
            {
                $new_product->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }
    public function run(): void
    {
        $products1 = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'The latest smartphone with an A17 Bionic chip and titanium design.',
                'price' => 1800000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/iphone-15-pro-image-primery.webp',
                    'products/iphone-15-pro-image.jpg',
                    'products/iphone-15-pro-image.webp',
                ],
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'A lightweight laptop with incredible performance and battery life.',
                'price' => 2500000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/mac-book-image-primery.jpg',
                    'products/mac-book-image.jpg',
                    'products/mac-book-image.webp',
                ],
            ],
            [
                'name' => 'iPad Pro',
                'description' => 'A high-performance tablet with the M2 chip and advanced display technology.',
                'price' => 1300000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/ipad-pro-image-primery.jpg',
                    'products/ipad-pro-image.jpg',
                    'products/ipad-pro-image2.jpg',
                ],
            ],
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'A smartwatch with fitness tracking and health monitoring.',
                'price' => 850000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/watch-os-9-image-primery.jpg',
                    'products/watch-os-9-image.avif',
                    'products/watch-os-9-image2.avif',
                ],
            ],
            [
                'name' => 'AirPods Pro 2',
                'description' => 'Noise-canceling wireless earbuds with spatial audio.',
                'price' => 750000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/airpod-pro-image-primery.png',
                    'products/airpod-pro-image.jpg',
                    'products/airpod-pro-image2.jpg',
                ],
            ],
            [
                'name' => 'Apple Pencil (2nd Gen)',
                'description' => 'A stylus for precise sketching and note-taking.',
                'price' => 200000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/pencil-image-primery.jpg',
                    'products/pencil-image.jpg',
                    'products/pencil-image2.jpg',
                ],
            ],
            [
                'name' => 'MagSafe Charger',
                'description' => 'A wireless charger for iPhones with magnetic alignment.',
                'price' => 350000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/magsafe-charger-image-primery.webp',
                    'products/magsafe-charger-image.jpg',
                    'products/magsafe-charger-image.webp',
                ],
            ],
            [
                'name' => 'HomePod Mini',
                'description' => 'A smart speaker with high-quality sound and Siri integration.',
                'price' => 550000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/homepod-mini-image-primery.jpg',
                    'products/homepod-mini-image.jpg',
                    'products/homepod-mini-image2.jpg',
                ],
            ],
            [
                'name' => 'Apple TV 4K',
                'description' => 'A streaming device for 4K HDR content with Dolby Vision.',
                'price' => 6500000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/tv-image-primery.webp',
                    'products/tv-image.jpg',
                    'products/tv-image2.jpg',
                ],
            ],
            [
                'name' => 'Beats Studio Pro',
                'description' => 'Premium over-ear headphones with active noise cancellation.',
                'price' => 950000,
                'quantity' => 1000,
                'store_id' =>1,
                'images' => [
                    'products/beat-studio-pro-image-primery.jpg',
                    'products/beat-studio-pro-image.jpg',
                    'products/beat-studio-pro-image2.jpg',
                ],

            ],
        ];

        $this->uploadeImages($products1);

        $products2 = [
            [
                'name' => 'Beauty Pro Set',
                'description' => 'A complete beauty set for makeup and skincare enthusiasts.',
                'price' => 1200000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/beauty-pro-image-primery.png',
                    'products/beauty-pro-image.jpg',
                    'products/beauty-pro-image2.jpg',
                ],
            ],
            [
                'name' => 'Benefit Cosmetics Set',
                'description' => 'A versatile cosmetic set with everything you need for flawless beauty.',
                'price' => 1500000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/benefit-image-primery.jpg',
                    'products/benefit-image.jpg',
                    'products/benefit-image2.jpg',
                ],
            ],
            [
                'name' => 'Makeup Brushes Set',
                'description' => 'A professional set of makeup brushes for a perfect application.',
                'price' => 500000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/brushes-set-image-primery.jpg',
                    'products/brushes-set-image.jpg',
                    'products/brushes-set-image2.jpg',
                ],
            ],
            [
                'name' => 'Dior Addict Lipstick',
                'description' => 'A luxurious lipstick with vibrant colors and long-lasting finish.',
                'price' => 300000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/doir-addict-image-primery.png',
                    'products/doir-addict-image.jpg',
                    'products/doir-addict-image2.jpg',
                ],
            ],
            [
                'name' => 'Drunk Elephant Skincare Set',
                'description' => 'A premium skincare set for glowing and healthy skin.',
                'price' => 1800000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/drunk-elephant-image-primery.jpg',
                    'products/drunk-elephant-image.jpg',
                    'products/drunk-elephant-image2.jpg',
                ],
            ],
            [
                'name' => 'Eyeshadow Palette',
                'description' => 'A vibrant eyeshadow palette for creative and colorful looks.',
                'price' => 800000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/eyershadow-palette-image-primery.jpg',
                    'products/eyershadow-palette-image.jpg',
                    'products/eyershadow-palette-image2.jpg',
                ],
            ],
            [
                'name' => 'Lip Sleeping Mask',
                'description' => 'A hydrating lip mask for soft and nourished lips.',
                'price' => 250000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/lip-sleeping-image-primery.jpg',
                    'products/lip-sleeping-image.jpg',
                    'products/lip-sleeping-image2.jpg',
                ],
            ],
            [
                'name' => 'Chanel No. 5',
                'description' => 'A timeless fragrance for a classic and elegant aroma.',
                'price' => 2000000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/No-5-image-primery.jpg',
                    'products/No-5-image.jpg',
                    'products/No-5-image2.jpg',
                ],
            ],
            [
                'name' => 'Tatcha The Water Cream',
                'description' => 'A refreshing moisturizer for hydrated and balanced skin.',
                'price' => 900000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/tatcha-the-water-cream-image-primery.jpg',
                    'products/tatcha-the-water-cream-image.jpg',
                    'products/tatcha-the-water-cream-image.webp',
                ],
            ],
            [
                'name' => 'Urban Decay Setting Spray',
                'description' => 'A setting spray for long-lasting and flawless makeup.',
                'price' => 350000,
                'quantity' => 1000,
                'store_id' => 3,
                'images' => [
                    'products/ueban-image-primery.jpg',
                    'products/ueban-image.jpg',
                    'products/ueban-image.webp',
                ],
            ],
        ];

        $this->uploadeImages($products2);

        $products3 = [
            [
                'name' => 'Air Max 270',
                'description' => 'Comfortable and stylish sneakers for everyday wear.',
                'price' => 800000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/air-max-270-image-primery.jpg',
                    'products/air-max-270-image.jpg',
                    'products/air-max-270-image.webp',
                ],
            ],
            [
                'name' => 'Sports Bra',
                'description' => 'Supportive and comfortable sports bra for workouts.',
                'price' => 300000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/bra-sport-image-primery.jpg',
                    'products/bra-sport-image.jpg',
                    'products/bra-sport-image.webp',
                ],
            ],
            [
                'name' => 'Brasilia Backpack',
                'description' => 'Durable and spacious backpack for all your essentials.',
                'price' => 400000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/brasilia-backpack-image-primery.jpg',
                    'products/brasilia-backpack-image.jpg',
                    'products/brasilia-backpack-image2.jpg',
                ],
            ],
            [
                'name' => 'Dri-FIT T-Shirt',
                'description' => 'Breathable and lightweight t-shirt for active wear.',
                'price' => 250000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/dri-fit-t-Shirt-image-primery.jpg',
                    'products/dri-fit-t-Shirt-image.jpg',
                    'products/dri-fit-t-Shirt-image.png',
                ],
            ],
            [
                'name' => 'Elite Basketball Socks',
                'description' => 'Comfortable and high-performance basketball socks.',
                'price' => 80000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/elite-bascketball-sockes-image-primery.jpg',
                    'products/elite-bascketball-sockes-image.jpeg',
                    'products/elite-bascketball-sockes-image.jpg',
                ],
            ],
            [
                'name' => 'Heritage Waistpack',
                'description' => 'A stylish and compact waistpack for convenience.',
                'price' => 200000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/heritage-waistpack-image-primery.png',
                    'products/heritage-waistpack-image.jpg',
                    'products/heritage-waistpack-image2.jpg',
                ],
            ],
            [
                'name' => 'Yoga Leggings',
                'description' => 'Flexible and durable leggings for yoga and workouts.',
                'price' => 180000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/legging-image-primery.jpg',
                    'products/legging-image.jpeg',
                    'products/legging-image2.jpeg',
                ],
            ],
            [
                'name' => 'Windrunner Jacket',
                'description' => 'Lightweight and weather-resistant jacket for outdoor activities.',
                'price' => 450000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/windrunner-jacket-image-primery.webp',
                    'products/windrunner-jacket-image.png',
                    'products/windrunner-jacket-image.webp',
                ],
            ],
            [
                'name' => 'Yoga Mat',
                'description' => 'A high-quality yoga mat for a comfortable workout.',
                'price' => 150000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/yoga-mat-image-primery.jpg',
                    'products/yoga-mat-image.jpg',
                    'products/yoga-mat-image.png',
                ],
            ],
            [
                'name' => 'Zoom Fly 4',
                'description' => 'High-performance running shoes for professional athletes.',
                'price' => 900000,
                'quantity' => 1000,
                'store_id' => 2,
                'images' => [
                    'products/zoom-fly-4-image-primery.jpg',
                    'products/zoom-fly-4-image.jpg',
                    'products/zoom-fly-4-image.png',
                ],
            ],
        ];

        $this->uploadeImages($products3);

        $products4 = [
            [
                'name' => 'Chunky Sneakers',
                'description' => 'Trendy and comfortable chunky sneakers.',
                'price' => 700000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/chunky-image-primery.jpg',
                    'products/chunky-image.jpg',
                    'products/chunky-image2.jpg',
                ],
            ],
            [
                'name' => 'Crossbody Bag',
                'description' => 'Stylish and practical crossbody bag.',
                'price' => 350000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/crossbody-image-primery.avif',
                    'products/crossbody-image.jpeg',
                    'products/crossbody-image.jpg',
                ],
            ],
            [
                'name' => 'Elegant Earrings',
                'description' => 'Beautiful earrings to complete any outfit.',
                'price' => 150000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/earring-image-primery.jpg',
                    'products/earring-image.jpg',
                    'products/earring-image2.jpg',
                ],
            ],
            [
                'name' => 'Floral Maxi Dress',
                'description' => 'A stunning maxi dress with floral patterns.',
                'price' => 500000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/floral-maxi-image-primery.jpg',
                    'products/floral-maxi-image.jpg',
                    'products/floral-maxi-image2.jpg',
                ],
            ],
            [
                'name' => 'High-Waisted Jeans',
                'description' => 'Comfortable and stylish high-waisted jeans.',
                'price' => 400000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/high-waisted-image-primery.jpg',
                    'products/high-waisted-image.jpg',
                    'products/high-waisted-image.webp',
                ],
            ],
            [
                'name' => 'Hoodie',
                'description' => 'A cozy and casual hoodie for everyday wear.',
                'price' => 300000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/hooodie-image-primery.jpg',
                    'products/hooodie-image.jpg',
                    'products/hooodie-image1.jpg',
                ],
            ],
            [
                'name' => 'Denim Jacket',
                'description' => 'Classic denim jacket for any season.',
                'price' => 450000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/jacket-jeans-image-primery.jpg',
                    'products/jacket-jeans-image.jpg',
                    'products/jacket-jeans-image1.jpg',
                ],
            ],
            [
                'name' => 'Leather Handbag',
                'description' => 'Elegant leather handbag for formal occasions.',
                'price' => 600000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/leather-image-primery.jpg',
                    'products/leather-image.jpg',
                    'products/leather-image.webp',
                ],
            ],
            [
                'name' => 'Off-Shoulder Top',
                'description' => 'Stylish off-shoulder top for casual outings.',
                'price' => 200000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/off-shoulder-image-primery.jpg',
                    'products/off-shoulder-image.jpg',
                    'products/off-shoulder-image2.jpg',
                ],
            ],
            [
                'name' => 'Pool Slippers',
                'description' => 'Comfortable and durable slippers for poolside.',
                'price' => 100000,
                'quantity' => 1000,
                'store_id' => 4,
                'images' => [
                    'products/pibool-image-primery.jpg',
                    'products/pibool-image.jpg',
                    'products/pibool-image2.jpg',
                ],
            ],
        ];

        $this->uploadeImages($products4);

        $products5 = [
            [
                'name' => 'Echo Dot (5th Gen)',
                'description' => 'A smart speaker with Alexa.',
                'price' => 700000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/echo-dot-image-primery.jpg',
                    'products/echo-dot-image.jpg',
                    'products/echo-dot-image.webp',
                ],
            ],
            [
                'name' => 'Fire TV Stick 4K',
                'description' => 'A streaming device for your TV.',
                'price' => 350000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/fire-tv-stick-image-primery.jpg',
                    'products/fire-tv-stick-image.jpg',
                    'products/fire-tv-stick-image2.avif',
                ],
            ],
            [
                'name' => 'Kindle Paperwhite',
                'description' => 'A lightweight e-reader with a glare-free screen.',
                'price' => 500000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/kindle-image-primery.jpg',
                    'products/kindle-image.jpg',
                    'products/kindle-image2.jpg',
                ],
            ],
            [
                'name' => 'Ring Video Doorbell',
                'description' => 'A smart doorbell with video monitoring.',
                'price' => 450000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/ring-video-image-primery.png',
                    'products/ring-video-image.jpg',
                    'products/ring-video-image2.jpg',
                ],
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Premium noise-canceling headphones.',
                'price' => 400000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/sony-image-primery.jpg',
                    'products/sony-image.jpg',
                    'products/sony-image2.jpg',
                ],
            ],
            [
                'name' => 'Fitbit Versa 3',
                'description' => 'A smartwatch for fitness tracking.',
                'price' => 300000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/fitbit-image-primery.jpg',
                    'products/fitbit-image.jpg',
                    'products/fitbit-image2.jpg',
                ],
            ],
            [
                'name' => 'Fire TV Stick',
                'description' => 'Streaming media player for 4K TV.',
                'price' => 150000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/fire-tv-stick-image-primery.jpg',
                    'products/fire-tv-stick-image2.jpg',
                    'products/fire-tv-stick-image.jpg',
                ],
            ],
            [
                'name' => 'Echo Dot (4th Gen)',
                'description' => 'Compact speaker with Alexa integration.',
                'price' => 900000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/echo-dot-image-primery.jpg',
                    'products/echo-dot-image.jpg',
                    'products/echo-dot-image.avif',
                ],
            ],
            [
                'name' => 'Kindle Paperwhite (2023)',
                'description' => 'Advanced e-reader with built-in light.',
                'price' => 50000,
                'quantity' => 1000,
                'store_id' => 5,
                'images' => [
                    'products/kindle-image-primery.jpg',
                    'products/kindle-image2.jpg',
                    'products/kindle-image.jpg',
                ],
            ]
        ];

        $this->uploadeImages($products5);
    }
}
