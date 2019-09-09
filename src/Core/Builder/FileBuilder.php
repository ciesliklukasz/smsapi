<?php

namespace App\Core\Builder;

use App\Core\Exception\ResourceNotExists;
use App\Core\Model\File;

class FileBuilder
{
    /**
     * @throws ResourceNotExists
     */
    public function build(string $filePath): File
    {
        if (false === file_exists($filePath))
        {
            throw new ResourceNotExists('File ' . $filePath . ' not found!');
        }

        $pathInfo = pathinfo($filePath);
        $baseName = $pathInfo['basename'];
        $extension = $pathInfo['extension'];
        $size = filesize($filePath);
        $encoding = mb_detect_encoding(file_get_contents($filePath));
        $content = file($filePath);

        return new File($baseName, $extension, $size, $encoding, $filePath, $content);
    }
}
