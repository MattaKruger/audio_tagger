<?php

declare(strict_types=1);

namespace AudioTagger\Interfaces;

interface AudioFileInterface
{
    public function getSize(): void;

    public function rename(): void;
}
