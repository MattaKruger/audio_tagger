<?php

declare(strict_types=1);

namespace AudioTagger\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use AudioTagger\Models\Playlist;
use AudioTagger\Services\PlaylistService;

class PlaylistController
{
    public function __construct(private PlaylistService $playlistService) {}

    public function index(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        try {
            $playlists = $this->playlistService->getAllPlaylists();
        } catch (\Exception $e) {
            return $this->errorResponse(
                $response,
                "Failed to retrieve playlists",
                500
            );
        }
    }
}
