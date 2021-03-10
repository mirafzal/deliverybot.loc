<?php


namespace App\Telegram\Pages\User;


use App\Telegram\Core\Page;
use App\Telegram\Pages\User;

class HomePage extends Page
{
    public function show($args = [])
    {
        $buttons = [
            "📁 Katalog", "🛍 Savat",
            "📞 Qayta aloqa", "🇺🇿🔄🇷🇺 Tilni o'zgartirish"
        ];
        if ($this->user->role === "editor") {
            $buttons[] = "👮‍♂️Admin Panel";
        }
        $keyboard = $this->buildKeyboard($buttons);
        return $this->sendMessage($args['text'] ?? "Bosh sahifa", $keyboard);
    }

    public function handle()
    {
        switch ($this->update->message->text) {
            case __("📁 Katalog"):
                return $this->go(User\Home\CatalogPage::class);
            case __("🛍 Savat"):
                return $this->go(User\Home\CartPage::class);
            case __("📞 Qayta aloqa"):
                return $this->sendMessage(
                    __("Bizning telefon raqamimiz:\n:phonenumber",
                        ['phonenumber' => "+998 99 123 45 67"]));
//                    . "\n+998 99 123 45 67");
            case __("🇺🇿🔄🇷🇺 Tilni o'zgartirish"):
                $this->changeLocale();
                return $this->goThis(['text' => __("Til muvaffaqiyatli o'zgartirildi.")]);
            case __("👮‍♂️Admin Panel"):
                return $this->go('gre');
        }
        return $this->goThis();
    }
}
