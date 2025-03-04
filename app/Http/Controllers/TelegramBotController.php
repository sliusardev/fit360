<?php

namespace App\Http\Controllers;

use App\Models\TelegraphChatUser;
use App\Models\User;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Http\Request;

class TelegramBotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $message = $request->input('message');

        if (!$message) {
            return response()->json(['ok' => true]);
        }

        $chatId = $message['chat']['id'];

        // Handle contact sharing
        if (isset($message['contact'])) {
            $this->handleContact($chatId, $message['contact']['phone_number']);
            return response()->json(['ok' => true]);
        }

        // Handle commands and messages
        $text = $message['text'] ?? '';

        switch ($text) {
            case '/start':
                $this->sendWelcomeMessage($chatId);
                break;
            default:
                $this->sendDefaultMessage($chatId);
        }

        return response()->json(['ok' => true]);
    }

    private function handleContact($chatId, $phoneNumber)
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);

        $user = User::query()->where('phone_number', $cleanPhone)->first();

        if ($user) {
            TelegraphChatUser::query()->create([
                'chat_id' => $chatId,
                'user_id' => $user->id,
            ]);

            Telegraph::message("Thank you! Your phone number has been successfully linked to your account.")
                ->chat($chatId)
                ->send();
        } else {
            Telegraph::message("Sorry, we couldn't find an account with this phone number. Please contact support.")
                ->chat($chatId)
                ->send();
        }
    }

    private function sendWelcomeMessage($chatId)
    {
        Telegraph::message("Welcome! Please share your phone number to link your account.")
            ->keyboard(Keyboard::make()->buttons([
                Button::make('Share Phone Number')->requestContact()
            ]))
            ->chat($chatId)
            ->send();
    }

    private function sendDefaultMessage($chatId)
    {
        Telegraph::message("Please use the button to share your phone number.")
            ->chat($chatId)
            ->send();
    }
}
