<?php


namespace App\Telegram\Pages\User\Home;


use App\Telegram\Core\Page;

class ProductsPage extends Page
{
    public $previous = CatalogPage::class;

    public function show($args = [])
    {
        $category = $this->user->category;
        $products = $category->products->pluck('name')->toArray();
        $keyboard = $this->buildKeyboard($products, 2, false);
        return $this->sendMessage(__('Produktni tanlang.'), $keyboard);
    }

    public function handle()
    {
        $products = $this->user->category->products;
        foreach ($products as $product) {
            if ($product->name === $this->update->message->text) {
                return $this->showProduct($product);
            }
        }
        return $this->goThis();
    }

}
