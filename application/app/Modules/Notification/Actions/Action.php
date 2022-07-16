<?php

namespace App\Modules\Notification\Actions;

use App\Modules\Notification\Actions\Concerns\BelongsToLivewire;
use App\Modules\Notification\Actions\Concerns\CanBeHidden;
use App\Modules\Notification\Actions\Concerns\CanBeMounted;
use App\Modules\Notification\Actions\Concerns\CanOpenModal;
use App\Modules\Notification\Actions\Concerns\CanOpenUrl;
use App\Modules\Notification\Actions\Concerns\CanRequireConfirmation;
use App\Modules\Notification\Actions\Concerns\EvaluatesClosures;
use App\Modules\Notification\Actions\Concerns\HasAction;
use App\Modules\Notification\Actions\Concerns\HasColor;
use App\Modules\Notification\Actions\Concerns\HasFormSchema;
use App\Modules\Notification\Actions\Concerns\HasIcon;
use App\Modules\Notification\Actions\Concerns\HasLabel;
use App\Modules\Notification\Actions\Concerns\HasName;
use App\Modules\Notification\Actions\Concerns\HasRecord;
use App\Modules\Notification\Actions\Concerns\HasView;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\CanBeOutlined;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\View\Component;
use function app;
use function view;

class Action extends Component implements Htmlable
{
    use BelongsToLivewire;
    use CanBeHidden;
    use CanBeMounted;
    use CanBeOutlined;
    use CanOpenModal;
    use CanOpenUrl;
    use CanRequireConfirmation;
    use EvaluatesClosures;
    use HasAction;
    use HasColor;
    use HasFormSchema;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasRecord;
    use HasView;
    use Conditionable;
    use Macroable;
    use Tappable;

    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->setUp();

        return $static;
    }

    protected function setUp(): void
    {
    }

    public function call(array $data = [])
    {
        if ($this->isHidden()) {
            return;
        }

        return $this->evaluate($this->getAction(), [
            'data' => $data,
        ]);
    }

    protected function getLivewireSubmitActionName(): string
    {
        return 'callMountedNotificationAction';
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }

    public function render(): View
    {
        return view($this->getView(), array_merge($this->data(), [
            'action' => $this,
        ]));
    }
}
