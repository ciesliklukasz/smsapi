<?php

use App\Application;
use App\Application\Comparer\TextFileComparer;
use App\Application\Subscriber\CompareEmailSubscriber;
use App\Application\Subscriber\CompareSmsSubscriber;
use App\Core\Builder\FileBuilder;
use App\Core\Comparer\ComparerInterface;
use App\Core\Registry\RepositoryRegistry;
use App\Core\Repository\RepositoryInterface;
use App\Infrastructure\Communication\MailSenderAdapter;
use App\Infrastructure\Communication\SMSSenderAdapter;
use App\Infrastructure\Repository\FileRepository;
use Psr\Container\ContainerInterface;

return [
    CompareEmailSubscriber::class => DI\autowire(CompareEmailSubscriber::class)
        ->constructor(DI\get(MailSenderAdapter::class)),
    CompareSmsSubscriber::class => DI\autowire(CompareSmsSubscriber::class)
        ->constructor(DI\get(SMSSenderAdapter::class)),
    FileRepository::class => DI\autowire(FileRepository::class),
    RepositoryRegistry::class => DI\autowire(RepositoryRegistry::class)
        ->method('register', DI\get(FileRepository::class)),
    RepositoryInterface::class => DI\factory(function (ContainerInterface $container) {
        $registry = $container->get(RepositoryRegistry::class);
        return $registry->getRepository(REPOSITORY);
    }),
    ComparerInterface::class => DI\autowire(TextFileComparer::class),
    Application::class => DI\autowire(Application::class)
        ->constructor(
            DI\get(FileBuilder::class),
            DI\get(ComparerInterface::class),
            DI\get(RepositoryInterface::class)
        ),

];
