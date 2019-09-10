<?php

namespace App\Infrastructure\Repository;

use App\Core\Model\Report;
use App\Core\Repository\RepositoryInterface;

class FileRepository implements RepositoryInterface
{
    private const TYPE = 'file_repository';
    private const DIFF_FILE_PATH =  __DIR__ . '/../../../tmp/test-%s.txt';

    public function save(Report $report): bool
    {
        $filePath = sprintf(self::DIFF_FILE_PATH, time());
        $handle = fopen($filePath, 'wb');

        if (false !== $handle)
        {
            fwrite($handle, 'File path: ' . $report->getFile()->getFilePath() . PHP_EOL);
            fwrite($handle, 'File size: ' . $report->getFile()->getSize() . PHP_EOL);
            foreach ($report->getDiff()->getAll() as $fileDiff)
            {
                foreach ($fileDiff as $file =>$item)
                {
                    fwrite($handle,'Compared file path: ' . $file . PHP_EOL);
                    fwrite($handle, $item);
                }
            }

            fclose($handle);
        }

        return true;
    }

    public function getType(): string
    {
        return self::TYPE;
    }
}
