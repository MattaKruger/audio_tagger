<?php

declare(strict_types=1);

namespace AudioTagger\Interfaces;

use AudioTagger\Models\AudioMetadata;

interface MetadataReaderInterface
{
    public function getMetadata(string $audioFile): ?AudioMetadata;
    /**
     * @return array{artist: string|null, title: string|null}
     */
    public function parseFilename(string $filename): array;
}
