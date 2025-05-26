<?php

declare(strict_types=1);

namespace AudioTagger\Utils;

use AudioTagger\Models\AudioMetadata;
use AudioTagger\Interfaces\MetadataReaderInterface;

require_once __DIR__ . "/../../vendor/autoload.php";

class AudioMetadataReader implements MetadataReaderInterface
{
    private \getID3 $getID3;

    // Use "\" to get the global class name
    public function __construct()
    {
        $this->getID3 = new \getID3();
    }
    /**
     * @return array<int,string|null>
     */
    public function parseFilename(string $filename): array
    {
        $basename = basename($filename);

        $nameWithoutExtension = pathinfo($basename, PATHINFO_FILENAME);
        $extension = pathinfo($basename, PATHINFO_EXTENSION);

        $parts = explode(" - ", $nameWithoutExtension, 2);
        if (count($parts) == 2) {
            return [
                "artist" => trim($parts[0]),
                "title" => trim($parts[1]),
            ];
        }

        return [
            "artist" => null,
            "title" => trim($nameWithoutExtension),
            "extension" => $extension,
        ];
    }

    public function getMetadata(string $audioFile): ?AudioMetadata
    {
        if (!is_readable($audioFile)) {
            error_log("Audio file not found or not readable: " . $audioFile);
            return null;
        }

        $fileInfo = $this->getID3->analyze($audioFile);

        // Try vorbiscomment for .flac files
        $tagArtist =
            $fileInfo["tags"]["id3v2"]["artist"][0] ??
            ($fileInfo["tags"]["vorbiscomment"]["artist"][0] ?? null);
        $tagTitle =
            $fileInfo["tags"]["id3v2"]["title"][0] ??
            ($fileInfo["tags"]["vorbiscomment"]["title"][0] ?? null);

        if (!$tagArtist || !$tagTitle) {
            $parsedFilename = $this->parseFilename($audioFile);
            $artist = $tagArtist ?? $parsedFilename["artist"];
            $title = $tagTitle ?? $parsedFilename["title"];
        } else {
            $artist = $tagArtist;
            $title = $tagTitle;
        }

        return new AudioMetadata(
            title: $title,
            artist: $artist,
            album: $fileInfo["tags"]["id3v2"]["album"][0] ??
                ($fileInfo["tags"]["vorbiscomment"]["album"][0] ?? null),
            extension: $fileInfo["fileformat"] ?? null,
            duration: (float) ($fileInfo["playtime_seconds"] ?? 0.0),
            bitrate: (int) ($fileInfo["audio"]["bitrate"] ?? 0),
            sampleRate: (int) ($fileInfo["audio"]["sample_rate"] ?? 0),
            channels: (int) ($fileInfo["audio"]["channels"] ?? 0),
            format: $fileInfo["fileformat"] ?? null,
            fileSize: (int) ($fileInfo["filesize"] ?? 0)
        );
    }
}
