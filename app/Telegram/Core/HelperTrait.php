<?php


namespace App\Telegram\Core;


use App\Models\Product;
use App\Telegram\Pages;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

trait HelperTrait
{
    protected function sendMessage($text, $keyboard = null, $parseMode = "HTML")
    {
        $content = [
            'chat_id' => $this->user->chat_id,
            'text' => $text,
            'parse_mode' => $parseMode
        ];
        if ($keyboard) {
            $content['reply_markup'] = $keyboard;
        }
        return Telegram::sendMessage($content);
    }

    private function editMessage($text = null, $keyboard = null)
    {
        if ($text === null && $keyboard === null) {
            return response();
        }
        $content = [
            'chat_id' => $this->update->getChat()->id,
            'message_id' => $this->update->getMessage()->messageId,
        ];
        if ($keyboard !== null) {
            $content['reply_markup'] = $keyboard;
        }
        if ($text) {
            $content['text'] = $text;
            $content['parse_mode'] = "HTML";
            return Telegram::editMessageText($content);
        }

        return Telegram::editMessageReplyMarkup($content);
    }

    protected function buildKeyboard($buttons = [], $columns = 2, $translate = true)
    {
        if (!is_array($buttons)) {
            $buttons = [$buttons];
        }
        if ($translate) {
            array_walk($buttons, static function (&$value) {
                $value = __($value);
            });
        }
        $buttons = array_chunk($buttons, $columns);
        if ($this->previousButton && isset($this->previous)) {
            $lastRow[] = __('⬅️ Orqaga');
            if ($this->homeButton
                && $this->previous !== Pages\User\HomePage::class
                && get_class($this) !== Pages\User\HomePage::class) {
                $lastRow[] = __('🏠 Bosh sahifa');
            }
            $buttons[] = $lastRow;
        }
        return Keyboard::make([
            'keyboard' => $buttons,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    protected function changeLocale($lang = null)
    {
        if (!$lang) {
            $lang = $this->user->language === 'uz-Latn-UZ' ? 'ru-RU' : 'uz-Latn-UZ';
        }
        $this->user->update(['language' => $lang]);
        App::setLocale($lang);
    }

    protected function showProduct(Product $product, $edit = false)
    {
        // build text
        if (config('app.env') === 'local') {
            $image = "https://067d6d3e3c01.ngrok.io/storage/" . $product->image;
        } else {
            $image = asset('storage/' . $product->image);
        }
        $text = "<a href=\"" . $image . "\"> </a>";
        $text .= $product->name ?? "";
        $text .= PHP_EOL;
        $text .= PHP_EOL;
        $text .= $product->info ?? "";

        // build keyboard
        $keyboard = Keyboard::make()->inline();
        foreach ($product->options as $option) {
            $buttonText = $option->name . " - "
                . number_format($option->price, 0, "", " ") . " "
                . __("so'm");
            $keyboard->row(
                Keyboard::inlineButton([
                    'text' => $buttonText,
                    'callback_data' => CallbackQueryManager::CHOOSE_COUNT . ";" . $option->id
                ])
            );
        }

        if ($edit) {
            return $this->editMessage($text, $keyboard);
        }

        return $this->sendMessage($text, $keyboard);
    }
}
