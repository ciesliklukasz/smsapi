<?php

namespace App\Application\Subscriber;

use App\Application\Event\ComparerEvent;
use App\Application\Event\ComparerEvents;
use App\Core\Adapter\MessageSenderAdapter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompareSmsSubscriber implements EventSubscriberInterface
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
            ComparerEvents::SEND_SMS => 'tryToSendSms'
        ];
    }

    public function trySendSms(ComparerEvent $event): void
    {
        $hasedFile = $event->getFile()->getEncoding();
        $hasedFileToCompare = $event->getComparedFile()->getEncoding();

        if ($hasedFile !== $hasedFileToCompare)
        {
            $message = sprintf(
                'Encoding of file: %s and %s are different',
                $event->getFile()->getFilePath(),
                $event->getComparedFile()->getFilePath()
            );
            $this->adapter->sendTo(RECIPIENT_PHONE_NUMBER, $message);
        }
    }
}
