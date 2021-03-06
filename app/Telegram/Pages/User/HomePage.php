<?php


namespace App\Telegram\Pages\User;


use App\Telegram\Core\Page;
use App\Telegram\Pages\User;

class HomePage extends Page
{
    public function show($args = [])
    {
        $buttons = [
            "๐ Katalog", "๐ Savat",
            "๐ Qayta aloqa", "๐บ๐ฟ๐๐ท๐บ Tilni o'zgartirish"
        ];
        if ($this->user->role === "editor") {
            $buttons[] = "๐ฎโโ๏ธAdmin Panel";
        }
        $keyboard = $this->buildKeyboard($buttons);
        return $this->sendMessage($args['text'] ?? "Bosh sahifa", $keyboard);
    }

    public function handle()
    {
        switch ($this->update->message->text) {
            case __("๐ Katalog"):
                return $this->go(User\Home\CatalogPage::class);
            case __("๐ Savat"):
                return $this->go(User\Home\CartPage::class);
            case __("๐ Qayta aloqa"):
                return $this->sendMessage(
                    __("Bizning telefon raqamimiz:\n:phonenumber",
                        ['phonenumber' => "+998 99 123 45 67"]));
//                    . "\n+998 99 123 45 67");
            case __("๐บ๐ฟ๐๐ท๐บ Tilni o'zgartirish"):
                $this->changeLocale();
                return $this->goThis(['text' => __("Til muvaffaqiyatli o'zgartirildi.")]);
            case __("๐ฎโโ๏ธAdmin Panel"):
                return $this->go('gre');
        }
        return $this->goThis();
    }
}
