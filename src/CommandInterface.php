<?php


namespace App;


interface CommandInterface
{
    public function execute(): void;
}