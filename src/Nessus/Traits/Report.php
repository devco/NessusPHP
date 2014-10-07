<?php

namespace Nessus\Traits;

trait Report
{
    public function reportList()
    {
        $reports = [];

        $response = $this->connect('report/list');

        if (isset($response['reports']['report'])) {
            if (isset($response['reports']['report']['0'])) {
                foreach ($response['reports']['report'] as $report) {
                    $reports[] = [
                        'name' => $report['name'],
                        'status' => $report['status'],
                        'readableName' => $report['readableName'],
                        'timestamp' => $report['timestamp']
                    ];
                }
            } else {
                $report = $response['reports']['report'];

                $reports[] = [
                    'name' => $report['name'],
                    'status' => $report['status'],
                    'readableName' => $report['readableName'],
                    'timestamp' => $report['timestamp']
                ];
            }
        }

        return $reports;
    }

    /**
     * @param $uuid Report name (uuid).
     */
    public function reportHosts($uuid)
    {
        $hosts = array();

        $response = $this->connect('report/hosts', ['report' => $uuid]);

        if (isset($response['hostlist']['host'])) {
            if (isset($response['hostlist']['host']['0'])) {
                foreach ($response['hostlist']['host'] as $host) {
                    $hosts[] = $this->hostToArray($host);
                }
            } else {
                $hosts[] = $this->hostToArray($response['hostlist']['host']);
            }
        }

        return $hosts;
    }

    /**
     * @param $uuid Report name (uuid).
     */
    public function reportDelete($uuid)
    {
        $response = $this->connect('report/delete', ['report' => $uuid]);

        if (isset($response['report']['name'])) {
            return [
                'name' => $response['report']['name']
            ];
        }
    }

    /**
     * @param $uuid Report name (uuid).
     *
     * @return string xml
     */
    public function reportDownload($uuid)
    {
        return $this->connect('file/report/download', ['report' => $uuid], true);
    }

    /**
     * @param $hostArray array Report host object.
     *
     * @return array
     */
    private function hostToArray(array $hostArray)
    {
        $host = [
            'hostname' => $hostArray['hostname'],
            'severity' => $hostArray['severity'],
            'scanprogresscurrent' => $hostArray['scanprogresscurrent'],
            'scanprogresstotal' => $hostArray['scanprogresstotal'],
            'numchecksconsidered' => $hostArray['numchecksconsidered'],
            'totalchecksconsidered' => $hostArray['totalchecksconsidered']
        ];

        if (is_array($hostArray['severitycount']['item'])) {
            foreach ($hostArray['severitycount']['item'] as $item) {
                $host['severitycount'][] = [
                    'severitylevel' => $item['severitylevel'],
                    'count' => $item['count']
                ];
            }
        }

        return $host;
    }
} 