<?php

namespace App\Services;

use App\Models\TelegraphChatUser;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
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
            $unsetResult = Process::run("php artisan telegraph:unset-webhook {$bot->id}");
            if (!$unsetResult->successful()) {
                Log::error('Failed to unset webhook: ' . $unsetResult->errorOutput());
                return;
            }

            $setResult = Process::run("php artisan telegraph:set-webhook {$bot->id}");
            if (!$setResult->successful()) {
                Log::error('Failed to set webhook: ' . $setResult->errorOutput());
                return;
            }

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
