<?php

use App\Application;
use App\Core\Presenter\ReportPresenter;
use DI\ContainerBuilder;

require_once 'vendor/autoload.php';

define('TMP_DIR', './tmp');
define('REPOSITORY', 'file_repository');
define('RECIPIENT_PHONE_NUMBER', 123456789);
define('RECIPIENT_EMAIL', 'test@test.pl');

$containerBuilder = new ContainerBuilder();

$files = include(__DIR__ . '/phpdi/application.php');
$containerBuilder->addDefinitions($files);
$containerBuilder->useAutowiring(true);

if(count($argv) <= 2)
{
    echo 'Invalid input!' . PHP_EOL;
    die();
}

unset($argv[0]);

$container = $containerBuilder->build();

try
{
    $application = $container->get(Application::class);
    $report = $application->run($argv);
    (new ReportPresenter())->pushContent($report);
}
catch (Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}

