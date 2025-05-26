<?php

declare(strict_types=1);

namespace AudioTagger\Models;

use PDO;
use BaseModel;
use DateTimeImmutable;
use AudioTagger\Models\Track;

class Playlist extends BaseModel
{
    /**
     * @var array<int, Track>|null $tracks;
     */

    protected string $table = "playlists";
    protected array $fillable = ["title", "description"];

    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?DateTimeImmutable $createdAt = null;
    private ?DateTimeImmutable $updatedAt = null;
    private array $tracks = [];
    private bool $tracksLoaded = false;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
    }

    public static function create(
        PDO $db,
        string $title,
        ?string $description = null
    ): self {
        $playlist = new self($db);
        $playlist->title = $title;
        $playlist->description = $description;
        $playlist->createdAt = new DateTimeImmutable();
        $playlist->updatedAt = new DateTimeImmutable();
        return $playlist;
    }

    public function save(): bool
    {
        if ($this->id === null) {
            return $this->insert();
        }
        return $this->update();
    }

    public function insert(): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO playlists (title, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?)"
        );
        $result = $stmt->execute([
            $this->title,
            $this->description,
            $this->createdAt->format("Y-m-d H:i:s"),
            $this->updatedAt->format("Y-m-d H:i:s"),
        ]);
        if ($result) {
            $this->id = $this->db->lastInsertId();
        }
        return $result;
    }

    private function update(): bool
    {
        $this->updatedAt = new DateTimeImmutable();

        $stmt = $this->db->prepare(
            "UPDATE playlists SET title = ?, description = ?, updated_at = ? WHERE id = ?"
        );
        return $stmt->execute([
            $this->title,
            $this->description,
            $this->updatedAt->format("Y-m-d H:i:s"),
            $this->id,
        ]);
    }

    public function addTrack(Track $track, ?int $position = null): bool
    {
        if ($this->id === null) {
            throw new \RuntimeException(
                "Playlist must be saved before adding tracks"
            );
        }

        if ($position === null) {
            $position = $this->getNextPosition();
        }

        $stmt = $this->db->prepare(
            "INSERT INTO playlist_tracks (playlist_id, track_id, position) VALUES (?,?,?)"
        );

        $result = $stmt->execute([$this->id, $track->getId(), $position]);

        if ($result) {
            $this->tracksLoaded = false;
        }
    }

    public function removeTrack(Track $track): bool
    {
        if ($this->id === null) {
            return false;
        }

        $stmt = $this->db->prepare(
            "DELETE FROM playlist_tracks WHERE playlist_id = ? AND track_id = ?"
        );

        $result = $stmt->execute([$this->id, $track->getId()]);

        if ($result) {
            $this->tracksLoaded = false;
            $this->reorderTracks();
        }

        return $result;
    }

    private function reorderTracks(): void
    {
        $stmt = $this->db->prepare(
            "SELECT id FROM playlist_tracks WHERE playlist_id ? ORDER BY position"
        );
        $stmt->execute([$this->id]);
        $trackIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($trackIds as $index => $trackId) {
            $updatedStmt = $this->db->prepare(
                "UPDATE playlist_tracks SET position = ? WHERE ID = ?"
            );
            $updatedStmt->execute([$index + 1, $trackId]);
        }
    }

    public function getTracks(): array
    {
        if ($this->tracksLoaded ?? $this->id !== null) {
            $this->loadTracks();
        }
        return $this->tracks;
    }

    public function loadTracks(): void
    {
        $stmt = $this->db->prepare(
            "SELECT t.* FROM tracks t
            JOIN playlist_tracks pt ON t.id = pt.track_id
            WHERE pt.playlist_id = ?
            ORDER BY pt.position"
        );
        $stmt->execute([$this->id]);

        $this->tracks = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->tracks[] = Track::fromArray($row);
        }
        $this->tracksLoaded = true;
    }

    public function getNextPosition(): int
    {
        $stmt = $this->db->prepare(
            "SELECT COALESCE(MAXA(position), 0) + 1 FROM playlist_tracks WHERE playlist_id = ?"
        );
        $stmt->execute([$this->id]);

        return (int) $stmt->fetchColumn();
    }

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
            $data["description"] ?? null,
            $data["tracks"] ?? [],
            $data["createdAt"] ?? new DateTimeImmutable()
        );
    }
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "tracks" => $this->tracks,
            "createdAt" => $this->createdAt->format(DateTimeImmutable::ATOM),
        ];
    }

    public function deepClone(): self
    {
        $clonedTracks = array_map(
            fn($track) => clone $track,
            $this->tracks ?? []
        );
        return new self(
            $this->title,
            $this->description,
            $clonedTracks,
            $this->createdAt
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPlaylistLength(): int
    {
        return count($this->tracks);
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCurrentPosition(): int {}

    public function getCurrentTrack(int $index): void {}
    public function getAllTracks(): void {}
    public function isEmpty(): bool {}
}
