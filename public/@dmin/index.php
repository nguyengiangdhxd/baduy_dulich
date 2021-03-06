<?php
use Flywheel\Debug\Profiler;

require __DIR__ .'/../../bootstrap.php';
$globalCnf = require ROOT_PATH . '/config.cfg.php';
$config = \Flywheel\Base::mergeArray( $globalCnf, require __DIR__ . '/../../apps/CMSBackend/Config/main.cfg.php');

$env = \Flywheel\Base::ENV_DEV;

try {
    $app = \Flywheel\Base::createWebApp($config, $env, false);
    $app->run();
} catch (\Exception $e) {
    if ($env != \Flywheel\Base::ENV_PRO) {
        \Flywheel\Exception::printExceptionInfo($e);
    } else {
        \Toxotes\ErrorHandler::exceptionHandling($e);
    }
}