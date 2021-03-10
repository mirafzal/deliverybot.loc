<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Telegram\Core\CallbackQueryManager;
use App\Telegram\Core\PageManager;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramBotController extends Controller
{
    public function index()
    {
        $update = Telegram::getWebhookUpdate();
        $user = $this->getUser($update);
        App::setLocale($user->language);
        if ($update->isType('callback_query')) {
            return (new CallbackQueryManager($update, $user))->handle();
        }

        return (new PageManager($update, $user))->handle();
    }

    private function getUser(Update $update): User
    {
        return User::firstOrCreate(['chat_id' => $update->getChat()->id]);
    }
}
