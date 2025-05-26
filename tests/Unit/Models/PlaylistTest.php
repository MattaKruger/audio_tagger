<?php

declare(strict_types=1);

namespace AudioTagger\Tests\Unit\Models;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

use AudioTagger\Models\Track;
use AudioTagger\Models\Playlist;

class PlaylistTest extends TestCase
{
    public function testContstructorWithDefaults(): void
    {
        $playlist = new Playlist();

        $this->assertNull($playlist->title);
        $this->assertNull($playlist->description);
        $this->assertEmpty($playlist->tracks);
        $this->assertNull($playlist->created_at);
    }

    public function testGetTitle(): void
    {
        $playlist = new Playlist("Test Title");
        $this->assertEquals("Test Title", $playlist->getTitle());
    }

    public function testGetDescription(): void
    {
        $playlist = new Playlist(description: "Test description");
        $this->assertEquals("Test description", $playlist->getDescription());
    }

    public function testGetPlaylistLength(): void
    {
        $tracks = [
            $this->createMockTrack(),
            $this->createMockTrack(),
            $this->createMockTrack(),
        ];
        $playlist = new Playlist(tracks: $tracks);
        $this->assertEquals(3, $playlist->getPlaylistLength());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable("2025-01-01 12:00:00");
        $playlist = new Playlist(createdAt: $createdAt);
        $this->assertEquals($createdAt, $playlist->getCreatedAt());
    }

    public function testFromArray(): void
    {
        $data = [
            "title" => "Array Playlist",
            "description" => "From array",
            "tracks" => [$this->createMockTrack()],
            "createdAt" => new DateTimeImmutable("2025-01-01"),
        ];

        $playlist = Playlist::fromArray($data);

        $this->assertEquals($data["title"], $playlist->title);
        $this->assertEquals($data["description"], $playlist->description);
        $this->assertEquals($data["tracks"], $playlist->tracks);
        $this->assertEquals($data["createdAt"], $playlist->createdAt);
    }

    public function testToString(): void
    {
        $playlist = new Playlist("JSON Playlist", "For JSON test");
        $jsonOutput = (string) $playlist;

        $this->assertJson($jsonOutput);

        $decoded = json_decode($jsonOutput, true);

        $this->assertEquals("JSON Playlist", $decoded["title"]);
        $this->assertEquals("For JSON test", $decoded["description"]);
    }

    public function testDeepClone(): void
    {
        $originalTrack = $this->createMockTrack();
        $playlist = new Playlist("Original", "Description", [$originalTrack]);

        $cloned = $playlist->deepClone();

        $this->assertNotSame($playlist, $cloned);
        $this->assertNotSame($playlist->tracks[0], $cloned->tracks[0]);

        $this->assertEquals($playlist->title, $cloned->title);
        $this->assertEquals($playlist->description, $cloned->description);
        $this->assertEquals($playlist->tracks, $cloned->tracks);
        $this->assertEquals($playlist->createdAt, $cloned->createdAt);
    }

    public function testDeepCloneWithEmptyTrack(): void
    {
        $playlist = new Playlist("Empty playlist");
        $cloned = $playlist->deepClone();

        $this->assertEquals($playlist->title, $cloned->title);
        $this->assertEmpty($cloned->tracks);
    }

    public function createMockTrack(): Track
    {
        return $this->createMock(Track::class);
    }
}
