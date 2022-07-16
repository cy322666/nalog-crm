<?php

namespace App\Modules\Notification\Actions\Modal\Actions;

use App\Modules\Notification\Actions\Modal\Actions\Concerns\CanCancelAction;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\CanSubmitForm;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\HasAction;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\HasColor;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\HasLabel;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\HasName;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\HasView;
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
    use CanCancelAction;
    use CanSubmitForm;
    use HasAction;
    use HasColor;
    use HasLabel;
    use HasName;
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
