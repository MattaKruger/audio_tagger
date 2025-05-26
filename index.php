<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use AudioTagger\Models\Track;
use AudioTagger\Models\Playlist;
use AudioTagger\Utils\AudioMetadataReader;

$filename = "data/MIKROTAKT - Kriya.flac";

$reader = new AudioMetadataReader();

$metadata = $reader->getMetadata($filename);

echo $metadata;
