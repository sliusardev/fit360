<?php

namespace App\Telegraph;

use App\Models\Activity;
use App\Models\TelegraphChatUser;
use App\Models\User;
use App\Services\SettingService;
use App\Services\TelegraphService;
use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stringable;

class TelegraphWebhookHandler extends WebhookHandler
{
    private array $defaultUserButtons = [];
    private array $defaultGuestButtons = [];

    public function __construct()
    {
        $this->defaultUserButtons = [
            ReplyButton::make('Групові тренування'),
            ReplyButton::make('Мої тренування'),
            ReplyButton::make('Контакти')->webApp(env('APP_URL').'/contacts'),
        ];

        $this->defaultGuestButtons = [
            ReplyButton::make('Групові тренування'),
            ReplyButton::make('Контакти')->webApp(env('APP_URL').'/contacts'),
            ReplyButton::make('Підключитися до акаунта')->requestContact(),
            ReplyButton::make('Зареєструватися на сайті')->webApp(env('APP_URL').'/panel/register'),
        ];
    }
    protected function handleChatMessage(Stringable $text): void
    {
        $message = $this->message->toArray();
        $chatId = $message['chat']['id'];
        $user = TelegraphService::getUserByChatId($chatId);

        if ($message['text'] == 'Групові тренування') {
            $this->showActivityList();
        }

        if ($message['text'] == 'Мої тренування') {
            $this->myActivityList($user);
        }

        if($message['text'] == '' && !empty($message['contact']['phone_number'])) {
            $this->showContactButton($message, $user);
        }

    }

    public function start()
    {
        $user = TelegraphService::getUserByChatId($this->chat->chat_id);

        if ($user) {
            $this->chat->message("Привіт {$user->full_name}!")
                ->replyKeyboard(ReplyKeyboard::make()->buttons($this->defaultUserButtons))
                ->send();
        } else {
            $this->chat->message('Привіт! Підключися до акаунта. Або зареєструйся')
                ->replyKeyboard(ReplyKeyboard::make()->buttons($this->defaultGuestButtons))->send();
        }
    }

    private function handleContact($chatId, $phoneNumber): void
    {
        $this->reply($phoneNumber);
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
        $shortPhone = $this->removeCountryCode($cleanPhone);
        $user = User::query()->where('phone', 'like', '%'.$shortPhone)->first();

        if (!$user) {
            Telegraph::message("Будь ласка, зареєструйтися")->send();
            return;
        }

        $telegraphChat = TelegraphChat::query()->where('chat_id', $chatId)->first();
        $telegraphChatUser = $user->telegraphChats()->where('chat_id', $chatId)->first();
        $message = 'Упс, щось пішло не так.. Спробуйте ще раз пізніше.';

        if ($telegraphChatUser) {
            $message = "Привіт: $user->full_name. Ви вже долучилися раніше.";
        }

        if ($user && $telegraphChat && !$telegraphChatUser) {
            TelegraphChatUser::query()->firstOrCreate([
                'telegraph_chat_id' => $telegraphChat->id,
                'user_id' => $user->id,
            ]);

            $message = "Привіт: $user->full_name, дякуємо, що долучилися!";
        }

        Telegraph::message($message)
            ->replyKeyboard(ReplyKeyboard::make()->buttons($this->defaultUserButtons))->send();
    }

    private function removeCountryCode($phoneNumber): string
    {
        // Common country codes you might want to remove
        $countryCodes = [
            '380', // Ukraine
            '1',   // USA/Canada
        ];

        foreach ($countryCodes as $code) {
            if (str_starts_with($phoneNumber, $code)) {
                return substr($phoneNumber, strlen($code));
            }
        }

        // If no country code matched, return original number without leading 0 if present
        return ltrim($phoneNumber, '0');
    }

    private function showContactButton(array $message, $user): void
    {
        $chatId = $message['chat']['id'];
        $this->chat->action(ChatActions::TYPING)->send();
        $this->reply('Перевіряємо...');

        if (!$user) {
            $this->handleContact($chatId, $message['contact']['phone_number']);
        }

        if ($user) {
            Telegraph::message("Привіт $user->full_name!")
                ->replyKeyboard(ReplyKeyboard::make()->buttons($this->defaultUserButtons))->send();
        }
    }

    private function showActivityList(): void
    {
        $activities = Activity::query()
            ->notStarted()
            ->active()
            ->with('users', 'trainers')
            ->orderBy('start_time', 'asc')
            ->get();

        $responseMessage = $this->prepareActivityList($activities);

        $this->reply($responseMessage);
    }

    private function myActivityList($user): void
    {
        $activities = $user->activities()->notStarted()->active()->get();

        $responseMessage = $this->prepareActivityList($activities);

        $this->reply($responseMessage);
    }

    private function prepareActivityList($activities): string
    {
        if ($activities->isEmpty()) {
            $responseMessage = 'Немає доступних групових тренувань.';
        } else {
            // Build a message with the list of activities
            $responseMessage = "Список групових тренувань:\n\n";
            foreach ($activities as $activity) {
                $usersCount = $activity->users()->count(); // Count of users registered for the activity
                $trainersList = $activity->trainers()->pluck('name')->implode(', '); // Get the trainers' names

                // Get a human-readable start time
                $startTime = $activity->startTimeHuman();
                $freeSlots = $activity->getFreeSlots();

                // Formatting activity details
                $responseMessage .= "- {$activity->title} \n (початок: {$startTime}) \n Тренери: {$trainersList} \n Зареєстровано: {$usersCount} учасників \n Вільних Місць: {$freeSlots} \n\n";
            }
        }

        return $responseMessage;
    }
}
