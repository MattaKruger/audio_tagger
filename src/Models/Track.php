<?php

declare(strict_types=1);

namespace AudioTagger\Models;

use AudioTagger\Models\AudioFile;
use AudioTagger\Models\AudioMetadata;

class Track extends AudioFile
{
    public function __construct(
        public string $title,
        public string $artist,
        public string $extension,
        public string $filename,
        public ?string $album,
        public ?float $bitrate,
        public ?AudioMetadata $metadata
    ) {
        parent::__construct($filename);
    }
}
