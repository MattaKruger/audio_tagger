<?php

declare(strict_types=1);

namespace AudioTagger\Enums;

enum AudioPlayerState: string
{
    case PLAYING = "playing";
    case PAUSED = "paused";
    case STOPPED = "stopped";
}
