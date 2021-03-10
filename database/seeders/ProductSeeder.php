<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => "🍕 Pitsa", 'products' => [
                ['name' => 'Margarita', 'info' => 'Tomat sousi, mozzarella pishloq, tomat va rayhon', 'image' => '1.jpg', 'options' => [
                    ['name' => "40 sm", 'price' => 50000],
                    ['name' => "50 sm", 'price' => 60000],
                ]],
                ['name' => 'Margarita2', 'info' => 'Tomat sousi, mozzarella pishloq, tomat va rayhon', 'image' => '1.jpg', 'options' => [
                    ['name' => "40 sm", 'price' => 50000],
                    ['name' => "50 sm", 'price' => 60000],
                ]],
                ['name' => 'Margarita3', 'info' => 'Tomat sousi, mozzarella pishloq, tomat va rayhon', 'image' => '1.jpg', 'options' => [
                    ['name' => "40 sm", 'price' => 50000],
                    ['name' => "50 sm", 'price' => 60000],
                ]],
                ['name' => 'Margarita4', 'info' => 'Tomat sousi, mozzarella pishloq, tomat va rayhon', 'image' => '1.jpg', 'options' => [
                    ['name' => "40 sm", 'price' => 50000],
                    ['name' => "50 sm", 'price' => 60000],
                ]],
            ]],
            ['name' => "🥞 Nonushta", 'products' => [
                ['name' => 'Omlet', 'info' => '', 'image' => '2.jpg', 'options' => [
                    ['name' => "Savatga", 'price' => 30000],
                ]],
                ['name' => 'Omlet2', 'info' => '', 'image' => '2.jpg', 'options' => [
                    ['name' => "Savatga", 'price' => 30000],
                ]],
                ['name' => 'Omlet3', 'info' => '', 'image' => '2.jpg', 'options' => [
                    ['name' => "Savatga", 'price' => 30000],
                ]],
            ]],
            ['name' => "🍝 Pasta", 'products' => []],
            ['name' => "🥪 Sendvich", 'products' => []],
            ['name' => "🍟 Gazak", 'products' => []],
            ['name' => "🥗 Salat", 'products' => []],
            ['name' => "🥤 Ichimliklar", 'products' => []],
        ];

        App::setLocale("uz-Latn-UZ");

        foreach ($categories as $category) {
            $newCategory = Category::create([
                'name' => $category['name']
            ]);
            foreach ($category['products'] as $product) {
                $newProduct = Product::create([
                    'name'  => $product['name'],
                    'info' => $product['info'],
                    'image' => $product['image']
                ]);
                $newProduct->category()->associate($newCategory)->save();
                foreach ($product['options'] as $option) {
                    $newOption = Option::create([
                        'name' => $option['name'],
                        'price' => $option['price']
                    ]);
                    $newOption->product()->associate($newProduct)->save();
                }
            }
        }
    }
}
