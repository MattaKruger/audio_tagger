<?php

declare(strict_types=1);

namespace AudioTagger\Models;

class Tag
{
    public function __construct(public string $name) {}

    public function updateName(string $newName): void
    {
        $this->name = $newName;
    }
}