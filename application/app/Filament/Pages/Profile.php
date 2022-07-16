<?php

namespace App\Filament\Pages;

use App\Events\Shop\TaskFailedPush;
use App\Models\Shop\Notification;
use App\Models\Shop\Task;
use App\Models\User;
use App\Notifications\Shop\TaskFailed;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class Profile extends \RyanChandler\FilamentProfile\Pages\Profile
{
    //TODO notif test
    public function __construct()
    {
//        event(new TaskFailedPush());//Task::query()->find(17)
//        User::query()->find(1)->notify(new TaskFailed(Task::query()->first()));

//        Notification::query()
//            ->create([
//                'title' => 'new push!',
//                'message' => 'new message push!',
//                'notifiable_id' => 1,
//                'link' => route('filament.pages.analytics'),
//                'notifiable_type' => User::class,
//            ]);
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'vendor.filament-profile.filament.pages.profile';

    //TODO changes + add avatar
}
