<?php

declare(strict_types=1);

namespace AudioTagger\Interfaces;

interface PlaylistInterface
{
    public function getAllPlaylists(): void;

    public function getAllTracks(): void;

    public function getTrackAt(int $index): Track;

    public function getCurrentIndex(): void;

    public function setCurrentIndex(int $index): int;

    public function isEmpty(): bool;

    public function getTrackCount(): int;
}
