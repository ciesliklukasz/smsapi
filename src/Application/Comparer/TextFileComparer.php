<?php

namespace App\Application\Comparer;

use App\Application\Event\ComparerEvent;
use App\Application\Event\ComparerEvents;
use App\Core\Comparer\ComparerInterface;
use App\Core\Container\DiffContainer;
use App\Core\Container\FileContainer;
use App\Core\Exception\CompareFileNotRegisteredException;
use App\Core\Model\Diff;
use App\Core\Model\File;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TextFileComparer implements ComparerInterface
{
    /** @var DiffContainer */
    private $diffContainer;
    /** @var EventDispatcher */
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->diffContainer = new DiffContainer();
        $this->dispatcher = $dispatcher;
    }

    public function compare(FileContainer $container): void
    {
        if (null === $container->getFile())
        {
            throw new CompareFileNotRegisteredException();
        }

        $file = $container->getFile();

        /** @var File $file */
        foreach ($container->getFileToCompare() as $fileToCompare)
        {
            $event = new ComparerEvent($file, $fileToCompare);
            $this->dispatcher->dispatch($event, ComparerEvents::SEND_EMAIL);
            $this->dispatcher->dispatch($event, ComparerEvents::SEND_SMS);

            $this->diffContainer->addDiff(
                $fileToCompare->getFilePath(),
                $this->compareWith($file, $fileToCompare)
            );
        }
    }

    public function getDiffContainer(): DiffContainer
    {
        return $this->diffContainer;
    }

    private function compareWith(File $file, File $fileToCompare): array
    {
        $fileContent = $file->getContent();
        $diffs = [];

        foreach ($fileToCompare->getContent() as $key => $line)
        {
            $theSameLine = $fileContent[$key] ?? '';

            $diffs = array_merge($diffs, $this->compareLines($key, $theSameLine, $line));
        }

        return $diffs;
    }

    private function compareLines(int $lineNo, string $line, string $lineToCompare): array
    {
        $diffs = [];
        if (md5($line) !== md5($lineToCompare))
        {
            $fileWords = explode(' ', $line);
            $compareFileWords = explode(' ', $lineToCompare);

            $count = str_word_count($line) > str_word_count($lineToCompare) ? str_word_count($line) : str_word_count($lineToCompare);

            for ($i = 0; $i < $count; $i++)
            {
                $fileWord = @$fileWords[$i];
                $compareFileWord = @$compareFileWords[$i];

                if ($fileWord !== $compareFileWord)
                {
                    $diffs[] = new Diff($lineNo, [$fileWord => $compareFileWord]);
                }
            }
        }

        return $diffs;
    }
}
