<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Elastic\Elasticsearch\ClientBuilder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $client = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200'])
            ->build();
        $products = [
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'GALAXY-S24',
                'name' => 'Smartphone Galaxy S24',
                'category' => 'Electronics',
                'description' => 'Latest flagship from Samsung with AI features.',
                'price' => 5999.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'KBD-RGB-01',
                'name' => 'Mechanical Keyboard RGB',
                'category' => 'Peripherals',
                'description' => 'Blue switches with custom RGB lighting.',
                'price' => 450.50,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'NIKE-AM270',
                'name' => 'Nike Air Max 270',
                'category' => 'Fashion',
                'description' => 'Comfortable running shoes for daily use.',
                'price' => 899.90,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'MBP-M3-14',
                'name' => 'MacBook Pro M3',
                'category' => 'Computers',
                'description' => 'High-performance laptop for professionals.',
                'price' => 12500.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'COFFEE-DLX',
                'name' => 'Coffee Maker Deluxe',
                'category' => 'Home',
                'description' => 'Programmable coffee maker with thermal carafe.',
                'price' => 299.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'IPHONE-15-PRO',
                'name' => 'iPhone 15 Pro',
                'category' => 'Electronics',
                'description' => 'Titanium design with A17 Pro chip.',
                'price' => 9499.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'SONY-WH1000XM5',
                'name' => 'Sony WH-1000XM5',
                'category' => 'Audio',
                'description' => 'Industry leading noise canceling headphones.',
                'price' => 2200.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'LOGI-MX-MAST3',
                'name' => 'Logitech MX Master 3S',
                'category' => 'Peripherals',
                'description' => 'Performance wireless mouse for productivity.',
                'price' => 550.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'DELL-U2723QE',
                'name' => 'Dell UltraSharp 27 4K',
                'category' => 'Computers',
                'description' => 'Professional monitor with IPS Black technology.',
                'price' => 3800.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'NIN-SWITCH-OLED',
                'name' => 'Nintendo Switch OLED',
                'category' => 'Gaming',
                'description' => 'Handheld console with vibrant OLED screen.',
                'price' => 2400.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'PS5-SLIM-DISC',
                'name' => 'PlayStation 5 Slim',
                'category' => 'Gaming',
                'description' => 'Next-gen gaming with Ultra-High Speed SSD.',
                'price' => 3799.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'ASUS-ROG-STRIX',
                'name' => 'ASUS ROG Strix G16',
                'category' => 'Computers',
                'description' => 'Powerful gaming laptop with RTX 4070.',
                'price' => 11500.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'BOSE-QC-EARBUDS',
                'name' => 'Bose QuietComfort II',
                'category' => 'Audio',
                'description' => 'World class noise cancellation in your ear.',
                'price' => 1800.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'RAZ-DEATH-V3',
                'name' => 'Razer DeathAdder V3 Pro',
                'category' => 'Peripherals',
                'description' => 'Ultra-lightweight wireless esports mouse.',
                'price' => 990.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'LG-C3-OLED-55',
                'name' => 'LG C3 OLED 55 inch',
                'category' => 'Electronics',
                'description' => 'Ultimate 4K gaming and cinema TV.',
                'price' => 7200.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'KINDLE-PAPER-16',
                'name' => 'Kindle Paperwhite 16GB',
                'category' => 'Electronics',
                'description' => 'Waterproof e-reader with adjustable warm light.',
                'price' => 799.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'DYSON-V15-DETECT',
                'name' => 'Dyson V15 Detect',
                'category' => 'Home',
                'description' => 'Cordless vacuum with laser dust detection.',
                'price' => 4500.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'LEVI-501-BLUE',
                'name' => 'Levi 501 Original Fit',
                'category' => 'Fashion',
                'description' => 'Classic straight leg denim jeans.',
                'price' => 349.90,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'RAYBAN-WAYFARER',
                'name' => 'Ray-Ban Wayfarer Classic',
                'category' => 'Fashion',
                'description' => 'Iconic sunglasses with G-15 lenses.',
                'price' => 850.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'STANLEY-QUENCH-40',
                'name' => 'Stanley Quencher 40oz',
                'category' => 'Home',
                'description' => 'Vacuum insulated tumbler with straw.',
                'price' => 280.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'WD-BLACK-2TB',
                'name' => 'WD Black SN850X 2TB',
                'category' => 'Computers',
                'description' => 'M.2 NVMe SSD for high-end gaming.',
                'price' => 1200.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'APP-WATCH-ULTRA2',
                'name' => 'Apple Watch Ultra 2',
                'category' => 'Electronics',
                'description' => 'Rugged smartwatch for athletes and explorers.',
                'price' => 8499.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'YETI-TUNDRA-45',
                'name' => 'Yeti Tundra 45 Cooler',
                'category' => 'Outdoor',
                'description' => 'Indestructible hard cooler for camping.',
                'price' => 2100.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'GOPRO-HERO-12',
                'name' => 'GoPro HERO12 Black',
                'category' => 'Electronics',
                'description' => 'Waterproof action camera with HDR video.',
                'price' => 2900.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::orderedUuid(),
                'sku' => 'PHIL-HUE-KIT',
                'name' => 'Philips Hue Starter Kit',
                'category' => 'Home',
                'description' => 'Smart LED bulbs with bridge and switch.',
                'price' => 899.00,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            $existProduct = DB::table('products')
                ->where('sku', $product['sku'])
                ->first();

            if (!$existProduct) {
                DB::table('products')->insert($product);

                try {
                    $client->index([
                        'index' => 'products',
                        'id' => $product['uuid'],
                        'body' => [
                            'uuid' => $product['uuid'],
                            'sku' => $product['sku'],
                            'name' => $product['name'],
                            'category' => $product['category'],
                            'description' => $product['description'],
                            'price' => (float) $product['price'],
                            'status' => $product['status'],
                            'imagePath' => $product['imagePath'] ?? null,
                        ]
                    ]);
                } catch (\Throwable $e) {
                    $this->command->error("Error indexando SKU {$product['sku']}: " . $e->getMessage());
                }
            }
        }
    }
}
