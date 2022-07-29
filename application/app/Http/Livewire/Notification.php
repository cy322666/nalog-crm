<?php

namespace App\Http\Livewire;

use App\Filament\Resources\Shop\NotificationResource;
use App\Modules\Notification\Concerns\HasActions;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use App\Modules\Notification\Actions\Concerns\HasAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class Notification extends Component implements Forms\Contracts\HasForms
{
    use WithPagination;
    use HasActions;
    use Forms\Concerns\InteractsWithForms;

    protected $feed;
    public int $totalUnread;
    public Collection $notifications;

    public function boot() {}

    public function reading()
    {
        Auth::user()
            ->unreadNotifications()
            ->getQuery()
            ->update([
                'read_at' => Carbon::now(),
                'is_read' => true,
            ]);

        $this->render();
    }

    public function notificationPage()
    {
        redirect(NotificationResource::getUrl());
    }

    /**
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        $unreadQuery = Auth::user()->unreadNotifications();

        $this->totalUnread = $unreadQuery->count();

        $this->notifications = $unreadQuery->limit(Config::get('crm-notification.limit'))->get();

        return view('livewire.notification', [
            'notifications' => $this->notifications,
        ]);
    }
}
