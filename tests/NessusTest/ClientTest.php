<?php

namespace NessusTest;
use Nessus;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new Nessus\Client();
    }

    public function testGoodConfig()
    {
        $url = 'https://test.com/';
        $port = 8834;
        $username = 'username';
        $password = 'password';

        $this->client->config($url, $port, $username, $password);
    }

    /**
     * @expectedException Nessus\Exception\InvalidUrl
     */
    public function testBadConfigUrl()
    {
        $url = 'test.com';
        $port = 8834;
        $username = 'username';
        $password = 'password';
        $e = null;

        $this->client->config($url, $port, $username, $password);
    }

    /**
     * @expectedException Nessus\Exception\InvalidPort
     */
    public function testBadConfigPort()
    {
        $url = 'https://test.com';
        $port = 0;
        $username = 'username';
        $password = 'password';
        $e = null;

        $this->client->config($url, $port, $username, $password);
    }

    public function testConfigByFile()
    {
        $file = dirname(__FILE__) .'/testConfig.json';

        $this->client->configByFile($file);
    }

    /**
     * Requires liveTestConfig.json in the this apps root folder.
     */
    public function testLogin()
    {
        $file = dirname(__FILE__) .'/../../liveTestConfig.json';

        $this->client->configByFile($file);
        $response = $this->client->login();

        $this->assertArrayHasKey('token', $response);
        $this->assertArrayHasKey('server_uuid', $response);
        $this->assertArrayHasKey('plugin_set', $response);
        $this->assertArrayHasKey('loaded_plugin_set', $response);
        $this->assertArrayHasKey('scanner_boottime', $response);
        $this->assertArrayHasKey('msp', $response);
        $this->assertArrayHasKey('idle_timeout', $response);
        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('name', $response['user']);
        $this->assertArrayHasKey('admin', $response['user']);

        return $this->client;
    }

    /**
     * @depends testLogin
     */
    public function testFeed($client)
    {
        $response = $client->feed();

        $this->assertArrayHasKey('feed', $response);
        $this->assertArrayHasKey('nessus_type', $response);
        $this->assertArrayHasKey('server_version', $response);
        $this->assertArrayHasKey('web_server_version', $response);
        $this->assertArrayHasKey('nessus_ui_version', $response);
        $this->assertArrayHasKey('expiration', $response);
        $this->assertArrayHasKey('msp', $response);
        $this->assertArrayHasKey('loaded_plugin_set', $response);
        $this->assertArrayHasKey('expiration_time', $response);
        $this->assertArrayHasKey('plugin_rules', $response);
        $this->assertArrayHasKey('report_email', $response);
        $this->assertArrayHasKey('tags', $response);
        $this->assertArrayHasKey('diff', $response);
        $this->assertArrayHasKey('multi_scanner', $response);
    }

    /**
     * @depends testLogin
     */
    public function testLogout($client)
    {
        $response = $client->logout();

        $this->assertEquals('OK', $response);
    }
} 