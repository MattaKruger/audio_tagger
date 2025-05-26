<?php

declare(strict_types=1);

namespace AudioTagger\Services;

use AudioTagger\Interfaces\PlaylistInterface;
use AudioTagger\Interfaces\AudioPlayerInterface;

class PlaylistService implements PlaylistInterface
{
    public function __construct(
        private PlaylistInterface $playlist,
        private AudioPlayerInterface $audioPlayer
    ) {}

    public function play(): void
    {
        $currentTrack = $this->playlist->getTrackAt(
            $this->playlist->getCurrentIndex()
        );
        if ($currentTrack) {
            $this->audioPlayer->play($currentTrack->getFilePath());
        }
    }

    public function next(): void
    {
        $nextIndex = $this->playlist->getCurrentIndex() + 1;
        if ($nextIndex < $this->playlist->getTrackCount()) {
            $this->playlist->setCurrentIndex($nextIndex);
            $this->play();
        }
    }

    public function previous(): void
    {
        $prevIndex = $this->playlist->getCurrentIndex() - 1;
        if ($prevIndex >= 0) {
            $this->playlist->getCurrentIndex();
            $this->play();
        }
    }

    public function jumpTo(int $index): void
    {
        if ($index >= 0 && $index < $this->playlist->getTrackCount()) {
            $this->playlist->setCurrentIndex($index);
            $this->play();
        }
    }

    public function updateTitle(string $title): void {}
    public function updateDescription(string $description): void {}

    public function addTrack(string $filepath): void {}
    public function getAllTracks(): void {}
    public function getTrackAt(): void {}
    public function getTrackCount(): int {}
    public function removeTrack(string $filepath): void {}

    public function getCurrentIndex(): void {}
    public function setCurrentIndex(): int {}
    public function isEmpty(): bool {}

    public function test(): void {}
    public function getAllPlaylists(): void {}
}
