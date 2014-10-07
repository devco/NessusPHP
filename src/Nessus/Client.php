<?php

namespace Nessus;
use Nessus\Traits;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;
use Nessus\Exception;

class Client
{
    protected $api;
    protected $url;
    protected $username;
    protected $password;
    const VERSION = '0.1.0';

    use Traits\Feed;
    use Traits\Policy;
    use Traits\Scan;
    use Traits\Scan\Template;
    use Traits\Report;

    public function configByFile($configFile)
    {
        if (!is_file($configFile)) {
            throw new \Exception('Config file does not exist! : ' . $configFile);
        }

        $config = json_decode(file_get_contents($configFile), true);

        $this->setUp($config['url'], $config['port'], $config['username'], $config['password']);
        $this->init();
    }

    public function config($url, $port, $username, $password)
    {
        $this->setUp($url, $port, $username, $password);
        $this->init();
    }

    public function setUp($url, $port, $username, $password)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception\InvalidUrl;
        }

        if (! (is_numeric($port) && $port > 0 && $port < 65535) ) {
            throw new Exception\InvalidPort();
        }

        $this->url = rtrim($url, '/') . ':' . $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function init()
    {
        $cookiePlugin = new CookiePlugin(new ArrayCookieJar());

        $this->api = new GuzzleClient($this->url);
        $this->api->addSubscriber($cookiePlugin);
    }

    public function connect($endpoint, $fields = [], $raw = false)
    {
        if (!($this->api instanceof GuzzleClient)) {
            throw new Exception\ClientNotConfigured();
        }

        $fields['seq'] = rand(1, 65535);
        $fields['json'] = 1;

        $options = array(
            'verify'    => false,
            'timeout'   => 30,
            'useragent' => 'PHPNessusAPI/' . self::VERSION
        );

        $request = $this->api->post($endpoint, [], $fields, $options)->send();

        if ($raw) {
            return $request->getBody(true);
        } else {
            $json = $request->json();

            return $json['reply']['contents'];
        }
    }

    public function login()
    {
        $fields = array(
            'login'    => $this->username,
            'password' => $this->password
        );

        return $this->connect('login', $fields);
    }

    public function logout()
    {
        return $this->connect('logout');
    }
}