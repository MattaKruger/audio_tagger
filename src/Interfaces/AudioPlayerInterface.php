<?php

declare(strict_types=1);

namespace AudioTagger\Interfaces;

interface AudioPlayerInterface
{
    public function play(?string $filepath = null): void;

    public function pause(): void;

    public function stop(): void;

    public function setVolume(int $volume): void;

    public function getVolumne(): int;

    public function getCurrentTrack(): ?string;

    public function isPlaying(): bool;
}
