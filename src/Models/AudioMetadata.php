<?php

declare(strict_types=1);

namespace AudioTagger\Models;

readonly class AudioMetadata
{
    public function __construct(
        public ?string $title = null,
        public ?string $artist = null,
        public ?string $extension = null,
        public ?string $album = null,
        public float $duration = 0.0,
        public int $bitrate = 0,
        public int $sampleRate = 0,
        public int $channels = 0,
        public ?string $format = null,
        public int $fileSize = 0
    ) {}

    public function __toString(): string
    {
        return json_encode(
            $this->toArray(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * @param array<int,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data["title"] ?? null,
            $data["artist"] ?? null,
            $data["extension"] ?? null,
            $data["album"] ?? null,
            $data["duration"] ?? 0.0,
            $data["bitrate"] ?? 0,
            $data["sampleRate"] ?? 0,
            $data["channels"] ?? 0,
            $data["format"] ?? null,
            $data["fileSize"] ?? 0
        );
    }
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "artist" => $this->artist,
            "extension" => $this->extension,
            "album" => $this->album,
            "duration" => $this->duration,
            "bitrate" => $this->bitrate,
            "sampleRate" => $this->sampleRate,
            "channels" => $this->channels,
            "format" => $this->format,
            "fileSize" => $this->fileSize,
        ];
    }

    public function hasBasicInfo(): bool
    {
        return !empty($this->title) && !empty($this->artist);
    }

    public function getFormattedDuration(): string
    {
        $minutes = floor($this->duration / 60);
        $seconds = (int) $this->duration % 60;
        return sprintf("%02d:%02d", $minutes, $seconds);
    }

    public function formatFileSize(): string
    {
        $units = ["B", "KB", "MB", "GB"];
        $size = $this->fileSize;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return number_format($size, 2) . " " . $units[$unitIndex];
    }
}
