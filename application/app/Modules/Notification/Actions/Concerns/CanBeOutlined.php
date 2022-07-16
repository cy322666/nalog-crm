<?php

namespace  App\Modules\Notification\Actions\Concerns;

use Closure;

trait CanBeOutlined
{
    protected bool $isOutlined = false;

    public function outlined(bool | Closure $condition = true): static
    {
        $this->isOutlined = $condition;

        return $this;
    }

    public function isOutlined(): bool
    {
        return $this->evaluate($this->isOutlined);
    }
}
