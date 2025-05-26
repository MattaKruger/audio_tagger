<?php

declare(strict_types=1);

namespace AudioTagger\Utils;

use AudioTagger\Enums\AudioPlayerState;
use AudioTagger\Interfaces\PlaylistInterface;
use AudioTagger\Interfaces\AudioPlayerInterface;

class AudioPlayer implements AudioPlayerInterface
{
    private PlaylistInterface $playlist;
    private AudioPlayerState $state = AudioPlayerState::STOPPED;
    private int $volume = 75;
    private ?array $currentTrack = null;

    // TODO: dive into process handler;
    // Who should handle the process? Look into php extensions;
    private $playbackProcess = null;

    public function __construct(?PlaylistInterface $playlist = null)
    {
        if ($playlist !== null) {
            $this->playlist = $playlist;
        }
    }

    public function play(?string $filepath = null): void {}
    public function pause(): void {}
    public function stop(): void {}
    public function setVolume(int $volume): void {}
    public function getVolumne(): int {}
    public function getCurrentTrack(): ?string {}
    public function isPlaying(): bool {}
}
