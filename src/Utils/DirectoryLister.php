<?php

declare(strict_types=1);

namespace AudioTagger\Utils;

use AudioTagger\Models\AudioMetadata;
use AudioTagger\Interfaces\MetadataReaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class DirectoryLister
{
    private MetadataReaderInterface $metadataReader;
    private Filesystem $filesystem;
    private array $supportedExtensions = [
        "mp3",
        "flac",
        "m4a",
        "wav",
        "ogg",
        "aac",
    ];

    public function __construct(?MetadataReaderInterface $metadataReader = null)
    {
        $this->metadataReader = $metadataReader ?? new AudioMetadataReader();
        $this->filesystem = new Filesystem();
    }
    /**
     * @return array<int,array<string,mixed>>
     */
    public function listFiles(string $directory): array
    {
        if (!$this->filesystem->exists($directory)) {
            throw new \InvalidArgumentException(
                "Directory does not exist: {$directory}"
            );
        }

        $finder = new Finder();
        $finder->files()->in($directory)->depth(0)->sortByName();

        $files = [];
        foreach ($finder as $file) {
            $files[] = [
                "filename" => $file->getFilename(),
                "path" => $file->getRealPath(),
                "size" => $file->getSize(),
                "extension" => $file->getExtension(),
                "is_audio" => $this->isAudioFile($file->getFilename()),
                "modified" => $file->getMTime(),
            ];
        }
        return $files;
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function listAudioFiles(string $directory): array
    {
        if (!this->filesystem->exists($directory)) {
            throw new \InvalidArgumentException(
                "Directory does not exist: {$directory}"
            );
        }

        $finder = new Finder();
        $finder
            ->files()
            ->in($directory)
            ->depth(0)
            ->name("/\.(" . implode("|", $this->supportedExtensions) . ')$/i')
            ->sortByName();

        $files = [];
        foreach ($finder as $file) {
            $files[] = [
                "filename" => $file->getFilename(),
                "path" => $file->getRealPath(),
                "size" => $file->getSize(),
                "extension" => $file->getExtension(),
                "is_audio" => $this->isAudioFile($file->getFilename()),
                "modified" => $file->getMTime(),
            ];
        }
        return $files;
    }

    public function displayFiles(
        string $directory,
        bool $audioOnly = false
    ): void {
        $files = $audioOnly
            ? $this->listAudioFiles($directory)
            : $this->listFiles($directory);

        if (empty($files)) {
            echo "No " .
                ($audioOnly ? "audio " : "") .
                "files found: {$directory}\n";
            return;
        }

        echo "===" .
            ($audioOnly ? "Audio" : "") .
            "Files in {$directory} === \n";

        echo sprintf("%-50s %-10s %-15s\n", "Filename", "Size", "Extension");
        echo str_repeat("-", 75) . PHP_EOL;

        foreach ($files as $file) {
            $size = $this->formatFileSize($file["size"]);
            echo sprintf(
                "%-50s %-10s %-15s\n",
                substr($file["filename"], 0, 49),
                $size,
                $file["extension"]
            );
        }

        echo "\nTotal files: " . count($files) . "\n";
    }

    private function isAudioFile(string $filename): bool
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $this->supportedExtensions);
    }

    private function formatFileSize(int $size): string
    {
        $units = ["B", "KB", "MB", "GB"];
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return number_format($size, 2) . " " . $units[$unitIndex];
    }
}
