<?php

namespace App\Services;

use App\Modules\Notification\Actions\ButtonAction;
use App\Modules\Notification\Notifications\NotificationLevel;
use Filament\Forms\Components\DatePicker;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationService extends Notification
{
    public function via($notifiable)
    {
        return [
            'database'
        ];
    }

    public function toArray($notifiable)
    {

        return [
            'level' => NotificationLevel::INFO,
            'title' => 'Info notification',
            'message' => 'Lorem ipsum'
        ];
    }

    static public function notificationFeedActions(): array
    {
        Log::info(__METHOD__, []);
        return [
            ButtonAction::make('markRead')->icon('heroicon-o-check')
                ->label('Mark as read')
                ->hidden(fn($record) => $record->read()) // Use $record to access/update notification, this is DatabaseNotification model
                ->action(function ($record, $livewire) {

                })
//                ->outlined(),
                ->color('danger'),
            ButtonAction::make('profile')
                ->label('Complete Profile')
                ->hidden(fn($record) => $record->read())
                ->icon('heroicon-o-user')
                ->action(function ($record, $livewire, $data) {

                    Log::info(__METHOD__, [$data]);
                    $record->markAsRead();
                    $livewire->refresh();
                    Auth::user()->update($data);
                })
                ->form([
                    DatePicker::make('birthday')
                        ->label('Birthday')
                        ->required(),
                ])
                ->modalHeading('Complete Profile')
                ->modalSubheading('Complete you profile information')
                ->modalButton('Save')
                ->outlined()
                ->color('secondary'),
        ];
    }
}
