<?php
use Robo\Tasks;

class Robofile extends Tasks
{
    public function testUnit()
    {
        $this
            ->taskPHPUnit(__DIR__ . '/vendor/bin/phpunit')
            ->configFile(__DIR__ . '/test')
            ->run()
        ;
    }
}
