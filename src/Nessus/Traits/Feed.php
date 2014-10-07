<?php

namespace Nessus\Traits;

trait Feed
{
    public function feed()
    {
        $response = $this->connect('feed');

        return [
            'feed' => $response['feed'],
            'nessus_type' => $response['nessus_type'],
            'server_version' => $response['server_version'],
            'web_server_version' => $response['web_server_version'],
            'nessus_ui_version' => $response['nessus_ui_version'],
            'expiration' => $response['expiration'],
            'msp' => $response['msp'],
            'loaded_plugin_set' => $response['loaded_plugin_set'],
            'expiration_time' => $response['expiration_time'],
            'plugin_rules' => $response['plugin_rules'],
            'report_email' => $response['report_email'],
            'tags' => $response['tags'],
            'diff' => $response['diff'],
            'multi_scanner' => $response['multi_scanner']
        ];
    }
} 