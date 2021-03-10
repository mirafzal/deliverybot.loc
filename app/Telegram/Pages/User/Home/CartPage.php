<?php


namespace App\Telegram\Pages\User\Home;


use App\Telegram\Core\Page;
use App\Telegram\Pages;

class CartPage extends Page
{

    public $previous = Pages\User\HomePage::class;

    public function show($args = [])
    {
        $keyboard = $this->buildKeyboard();
        return $this->sendMessage('cart page', $keyboard);
    }

    public function handle()
    {
        // TODO: Implement handle() method.
    }
}
