<?php

namespace NessusTest;
use Nessus;

abstract class LiveTestAbstract extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Nessus\Client
     */
    protected static $client;

    public static function setUpBeforeClass()
    {
        self::$client = new Nessus\Client();

        $file = dirname(__FILE__) .'/../../liveTestConfig.json';

        self::$client->configByFile($file);
        self::$client->login();
    }

    public static function tearDownAfterClass()
    {
        self::$client->logout();
    }
} 