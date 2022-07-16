<?php

namespace App\Modules\Notification\Actions\Modal\Actions;

use App\Modules\Notification\Actions\Modal\Actions\Concerns\CanBeOutlined;
use App\Modules\Notification\Actions\Modal\Actions\Concerns\HasIcon;

class ButtonAction extends Action
{
    use CanBeOutlined;
    use HasIcon;

    protected string $view = 'notification.actions.modal.actions.button-action';

    protected ?string $iconPosition = null;

    public function iconPosition(string $position): static
    {
        $this->iconPosition = $position;

        return $this;
    }

    public function getIconPosition(): ?string
    {
        return $this->iconPosition;
    }
}
