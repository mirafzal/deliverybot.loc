<?php


namespace App\Telegram\Pages;

use App\Telegram\Core\Page;
use App\Telegram\Pages;

class StartPage extends Page
{
    public $next = Pages\User\ChangeLanguagePage::class;

    public function show($args = [])
    {
        return $this->goNext();
    }

    public function handle()
    {
        return $this->goNext();
    }
}
