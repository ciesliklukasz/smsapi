<?php

namespace App\Application\Subscriber;

use App\Application\Event\ComparerEvent;
use App\Application\Event\ComparerEvents;
use App\Core\Adapter\MessageSenderAdapter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompareEmailSubscriber implements EventSubscriberInterface
{
    /** @var MessageSenderAdapter */
    private $adapter;

    public function __construct(MessageSenderAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ComparerEvents::SEND_EMAIL => 'tryToSendEmail',
        ];
    }

    public function trySendEmail(ComparerEvent $event): void
    {
        $hasedFile = md5(json_encode($event->getFile()->getContent()));
        $hasedFileToCompare = md5(json_encode($event->getComparedFile()->getContent()));

        if ($hasedFile !== $hasedFileToCompare)
        {
            $message = sprintf(
                'File: %s and %s are different',
                $event->getFile()->getFilePath(),
                $event->getComparedFile()->getFilePath()
            );
            $this->adapter->sendTo(RECIPIENT_EMAIL, $message);
        }
    }
}
