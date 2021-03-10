<?php


namespace App\Telegram\Pages\User\Home;


use App\Models\Category;
use App\Telegram\Core\Page;
use App\Telegram\Pages\User;

class CatalogPage extends Page
{
    public $previous = User\HomePage::class;
    public $next = User\Home\ProductsPage::class;

    public function show($args = [])
    {
        $categories = Category::all()->pluck('name')->toArray();
        $keyboard = $this->buildKeyboard($categories, 2, false);
        return $this->sendMessage($args['text'] ?? __("Bo'limni tanlang."), $keyboard);
    }

    public function handle()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            if ($category->name === $this->update->message->text) {
                $this->user->update(['category_id' => $category->id]);
                return $this->goNext();
            }
        }
        return $this->goThis();
    }
}
