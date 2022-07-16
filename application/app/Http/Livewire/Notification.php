<?php

namespace App\Http\Livewire;

use App\Modules\Notification\Concerns\HasActions;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Notifications\DatabaseNotification;
use App\Modules\Notification\Actions\Concerns\HasAction;
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
    public $totalUnread;

    public function boot()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->hydrateNotificationFeed();
        $this->prepareActions();
    }

    public function hydrateNotificationFeed()
    {
        $this->feed = Auth::user()
            ->notifications()
            ->orderByDesc('created_at')
            ->limit(Config::get('crm-notification.limit'))
            ->get();

        $this->totalUnread = Auth::user()->unreadNotifications()->count();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        $this->refresh();
    }

    protected function getForms(): array
    {
        return [
            'mountedNotificationActionForm' => $this->makeForm()
                ->schema(($action = $this->getMountedNotificationAction()) ? $action->getFormSchema() : [])
                ->model($this->getMountedNotificationActionRecord() ?? DatabaseNotification::class)
                ->statePath('mountedNotificationActionData'),
        ];
    }

    protected function resolveNotificationRecord(?string $key): ?Model
    {
        return DatabaseNotification::find($key);
    }

    protected function prepareActions(): void
    {
        foreach ($this->feed as $notification) {
            if (isset($this->cachedNotificationActions[$notification->type])) {
                continue;
            }
            $actions = [];
            if(method_exists($notification->type, 'notificationFeedActions')) {
                $actions = call_user_func([$notification->type, 'notificationFeedActions']);
            }
            $this->cacheNotificationActions($notification->type, $actions);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.notification', [
            'notifications' => $this->feed
        ]);
    }
}
