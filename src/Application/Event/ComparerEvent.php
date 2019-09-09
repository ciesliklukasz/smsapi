<?php

namespace App\Application\Event;

use App\Core\Model\File;
use Symfony\Component\EventDispatcher\GenericEvent;

class ComparerEvent extends GenericEvent
{
    /** @var File */
    private $file;
    /** @var File */
    private $comparedFile;

    public function __construct(File $file, File $comparedFile)
    {
        $this->file = $file;
        $this->comparedFile = $comparedFile;
        parent::__construct();
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getComparedFile(): File
    {
        return $this->comparedFile;
    }
}
