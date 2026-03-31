<?php

declare(strict_types=1);

namespace Tinigin\ETag;

class ETag
{
    private ?string $hash = null;

    public function set(?string $content): void
    {
        $this->hash = $content ? md5($content) : null;
    }

    public function get(): ?string
    {
        return $this->hash;
    }
}
