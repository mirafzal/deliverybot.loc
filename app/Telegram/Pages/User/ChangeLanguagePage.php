<?php


namespace App\Telegram\Pages\User;

use App\Telegram\Core\Page;
use App\Telegram\Pages;

class ChangeLanguagePage extends Page
{
    public $next = Pages\User\HomePage::class;

    private array $buttons = ["🇷🇺 Русский", "🇺🇿 O'zbekcha"];

    public function show($args = [])
    {
        $text = "Пожалуйста выберите язык. 👇" . PHP_EOL
            . PHP_EOL
            . "Iltimos, tilni tanlang. 👇";

        $keyboard = $this->buildKeyboard($this->buttons);
        return $this->sendMessage($text, $keyboard);
    }

    public function handle()
    {
        switch ($this->update->message->text) {
            case "🇷🇺 Русский":
                $this->changeLocale('ru-RU');
                return $this->goNext();
            case "🇺🇿 O'zbekcha":
                $this->changeLocale('uz-Latn-UZ');
                return $this->goNext();
            default:
                return $this->goThis();
        }
    }
}
