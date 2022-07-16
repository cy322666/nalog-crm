<?php

namespace App\Modules\Notification\Actions;

use App\Modules\Notification\Actions\Concerns\CanBeOutlined;
use Closure;

class ButtonAction extends Action
{
    use CanBeOutlined;

    protected string $view = 'notification.actions.button-action';

    protected string | Closure | null $iconPosition = null;

    public function iconPosition(string | Closure | null $position): static
    {
        $this->iconPosition = $position;

        return $this;
    }

    public function getIconPosition(): ?string
    {
        return $this->evaluate($this->iconPosition);
    }
}
