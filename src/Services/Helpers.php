<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class Helpers
{


    public function __construct(private LoggerInterface $logger)
    {
    }


    public function sayHello() : string
    {
        $this->logger->info("Calling the sayHello Method");
        return "Hello";
    }

}