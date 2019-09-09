<?php

namespace App\Core\Model;

class File
{
    /** @var string */
    private $baseName;
    /** @var string */
    private $extension;
    /** @var int */
    private $size;
    /** @var string */
    private $encoding;
    /** @var string */
    private $filePath;
    /** @var array */
    private $content;

    public function __construct(
        string $baseName,
        string $extension,
        int $size,
        string $encoding,
        string $filePath,
        array $content
    ) {
        $this->baseName = $baseName;
        $this->extension = $extension;
        $this->size = $size;
        $this->encoding = $encoding;
        $this->filePath = $filePath;
        $this->content = $content;
    }

    public function getBaseName(): string
    {
        return $this->baseName;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
