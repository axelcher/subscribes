<?php

use App\CommandScheduler;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

(new CommandScheduler())->run($config, $argv);


