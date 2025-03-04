<?php

namespace App\Services;

use App\Models\TelegraphChatUser;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Artisan;
use Log;

class TelegraphService
{
    public static function createMainBot(): void
    {
        TelegraphBot::create([
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'name' => env('TELEGRAM_BOT_NAME'),
        ]);
    }
    public static function setMainWebhook(): void
    {
        try {
            $bot = TelegraphBot::query()->where("token", env('TELEGRAM_BOT_TOKEN'))->first();

            if (!$bot) {
                Log::error('Telegraph bot not found with the provided token.');
                return;
            }

            // Run the artisan command to set the webhook
            Artisan::call('telegraph:unset-webhook', ['bot' => $bot->id]);
            Artisan::call('telegraph:set-webhook', ['bot' => $bot->id]);

            Log::info('Webhook successfully set for the main bot.');
        } catch (\Exception $e) {
            Log::error('Failed to set webhook for the main bot: ' . $e->getMessage());
        }
    }


    public static function getUserByChatId($chatId)
    {
        $telegraphChat = TelegraphChat::query()
            ->where("chat_id", $chatId)
            ->first();

        $telegraphChatUser = TelegraphChatUser::query()
            ->where("telegraph_chat_id", $telegraphChat->id)
            ->with("user")
            ->first();

        if (!$telegraphChat || !$telegraphChatUser) {
            return null;
        }

        return $telegraphChatUser->user;
    }

}
