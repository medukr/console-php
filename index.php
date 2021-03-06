#!/usr/bin/env php
<?php
require_once __DIR__ . '/config.php';

use app\console\commands\FakerFilesCommand;
use app\console\commands\FindFileCommand;
use app\console\commands\UserCreateCommand;
use app\console\commands\UserAllCommand;
use app\console\commands\UserPopulateCommand;
use app\console\commands\UserSearchCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new UserCreateCommand());
$app->add(new UserPopulateCommand());
$app->add(new UserAllCommand());
$app->add(new UserSearchCommand());
$app->add(new FindFileCommand());
$app->add(new FakerFilesCommand());
$app->run();
