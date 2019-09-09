<?php

namespace App\Core\Container;

use App\Core\Exception\CannotOverwriteCompareFileException;
use App\Core\Model\File;

class FileContainer
{
    /** @var File|null */
    private $file;
    /** @var File[] */
    private $fileToCompare = [];

    public function addFile(File $file): void
    {
        if (null === $this->file)
        {
            $this->file = $file;
            return;
        }

        throw new CannotOverwriteCompareFileException('Compare file is registered!');
    }

    public function addFileToCompare(File $file): void
    {
        $this->fileToCompare[$file->getFilePath()] = $file;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @return array
     */
    public function getFileToCompare(): array
    {
        return $this->fileToCompare;
    }
}
