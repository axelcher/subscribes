<?php

namespace App;

/**
 * Class Command
 * @package App
 */
class CommandScheduler
{
    private const PATH = 'App\\';

    public function run(array $config, array $argv): void
    {
        $class = self::PATH . $argv[1];
        if (class_exists($class) && in_array(CommandInterface::class, class_implements($class))) {
            /** @var CommandInterface $command */
            $command = new $class($config, ...array_slice($argv, 2));
            $command->execute();
        } else {
            echo "Command $class doesn`t exist\r\n";
        }
    }
}