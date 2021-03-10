<?php


namespace App\Telegram\Core;


use App\Models\Option;
use App\Models\User;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class CallbackQueryManager implements Manager
{
    use HelperTrait;

    public const CHOOSE_COUNT = "chooseCount";
    public const ADD_TO_CART = 'addToCart';
    public const BACK_CHOOSE_COUNT = 'backChooseCount';

    private Update $update;
    private User $user;

    public function __construct(Update $update, User $user)
    {
        $this->update = $update;
        $this->user = $user;
    }

    public function handle()
    {
        $this->answerCallbackQuery();

        $data = explode(';', $this->update->callbackQuery->data);
        $method = $data[0];
        switch ($method) {
            case self::CHOOSE_COUNT:
                $option = $data[1];
                return $this->showNumberKeyboard($option);
            case self::BACK_CHOOSE_COUNT:
                $option = Option::find($data[1]);
                $product = $option->product;
                return $this->showProduct($product, true);
            case self::ADD_TO_CART:

                return $this->editMessage('gg');
            default:
                return response();
        }
    }

    private function showNumberKeyboard($option)
    {
        $numbers = [
            ['1️⃣', '2️⃣', '3️⃣'],
            ['4️⃣', '5️⃣', '6️⃣'],
            ['7️⃣', '8️⃣', '9️⃣']
        ];
        $keyboard = Keyboard::make()->inline();
        $counter = 1;
        foreach ($numbers as $numberRow) {
            $rowButtons = [];
            foreach ($numberRow as $number) {
                $rowButtons[] = Keyboard::inlineButton([
                    'text' => $number,
                    'callback_data' => self::ADD_TO_CART . ';' . $option . ';' . $counter
                ]);
                $counter++;
            }
            $keyboard->row(...$rowButtons);
        }
        $keyboard->row(
            Keyboard::inlineButton([
                'text' => '⬅️ Orqaga',
                'callback_data' => self::BACK_CHOOSE_COUNT . ';' . $option
            ])
        );

        return $this->editMessage(__("Iltimos, mahsulot miqdorini tanlang:"), $keyboard);
    }

    private function answerCallbackQuery()
    {
        return Telegram::answerCallbackQuery([
            'callback_query_id' => $this->update->callbackQuery->id,
//            'text' => $this->update->callbackQuery->data,
//                'show_alert' => true
        ]);
    }
}
