<?php

namespace App\Filament\Pages;

use App\Events\Shop\Push\Task\TaskCreated;

class Profile extends \RyanChandler\FilamentProfile\Pages\Profile
{
    //TODO notif test
    public function __construct()
    {
//        event(new TaskFailedPush());//Task::query()->find(17)
//        User::query()->find(1)->notify(new TaskFailed(Task::query()->first()));
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'vendor.filament-profile.filament.pages.profile';

    //TODO changes + add avatar
}
