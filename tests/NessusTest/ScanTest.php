<?php

namespace NessusTest;
use Nessus;

class ScanTest extends LiveTestAbstract
{
    public function testPolicyList()
    {
        $policies = self::$client->policyList();

        $this->assertArrayHasKey('0', $policies);

        $policy = $policies['0'];

        $this->assertArrayHasKey('policyid', $policy);
        $this->assertArrayHasKey('policyname', $policy);

        return $policies;
    }

    /**
     * @depends testPolicyList
     */
    public function testTemplateNew($policies)
    {
        if (!isset($policies['0']['policyid'])) {
            throw new \Exception('No policies found');
        }

        $policy_id = $policies['0']['policyid'];

        $template = self::$client->templateNew(
            'TestTemplate',
            $policy_id,
            '127.0.0.1/30',
            (new \DateTime())->format('Ymd\THisO')
        );

        $this->assertArrayHasKey('readableName', $template);
        $this->assertArrayHasKey('policy_id', $template);
        $this->assertArrayHasKey('name', $template);
        $this->assertArrayHasKey('startTime', $template);
        $this->assertArrayHasKey('rRules', $template);
        $this->assertArrayHasKey('target', $template);
        $this->assertArrayHasKey('owner', $template);

        return $template;
    }

    public function testTemplateList()
    {
        $templates = self::$client->templateList();

        $this->assertArrayHasKey('0', $templates);

        $template = $templates['0'];

        $this->assertArrayHasKey('name', $template);
        $this->assertArrayHasKey('policy_name', $template);
        $this->assertArrayHasKey('type', $template);
        $this->assertArrayHasKey('rrules', $template);
        $this->assertArrayHasKey('starttime', $template);
        $this->assertArrayHasKey('uuid', $template);
        $this->assertArrayHasKey('owner', $template);
        $this->assertArrayHasKey('shared', $template);
        $this->assertArrayHasKey('user_permissions', $template);
        $this->assertArrayHasKey('timestamp', $template);
        $this->assertArrayHasKey('last_modification_date', $template);
        $this->assertArrayHasKey('creation_date', $template);
        $this->assertArrayHasKey('owner_id', $template);
        $this->assertArrayHasKey('id', $template);
    }

    /**
     * @depends testTemplateNew
     */
    public function testTemplateLaunch($template)
    {
        $response = self::$client->templateLaunch($template['name']);

        sleep(3);

        $this->assertArrayHasKey('start_time', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('uuid', $response);
        $this->assertArrayHasKey('owner', $response);
        $this->assertArrayHasKey('type', $response);
        $this->assertArrayHasKey('id', $response);
    }

    public function testScanList()
    {
        $response = self::$client->scanList();

        $size = count($response);
        $lastKey = $size > 1 ? $size - 1 : 0;
        $scan = $response[$lastKey];

        $this->assertArrayHasKey('uuid', $scan);
        $this->assertArrayHasKey('completion_current', $scan);
        $this->assertArrayHasKey('completion_total', $scan);
        $this->assertArrayHasKey('readableName', $scan);
        $this->assertArrayHasKey('status', $scan);
        $this->assertArrayHasKey('start_time', $scan);

        return $scan;
    }

    public function testReportList()
    {
        $reports = self::$client->reportList();

        $this->assertArrayHasKey('0', $reports);

        $size = count($reports);
        $lastKey = $size > 1 ? $size - 1 : 0;
        $report = $reports[$lastKey];

        $this->assertArrayHasKey('name', $report);
        $this->assertArrayHasKey('status', $report);
        $this->assertArrayHasKey('readableName', $report);
        $this->assertArrayHasKey('timestamp', $report);

        return $report;
    }

    /**
     * @depends testReportList
     */
    public function testReportHosts($report)
    {
        $hosts = self::$client->reportHosts($report['name']);

        $this->assertArrayHasKey('0', $hosts);

        $host = $hosts['0'];

        $this->assertArrayHasKey('hostname', $host);
        $this->assertArrayHasKey('severity', $host);
        $this->assertArrayHasKey('scanprogresscurrent', $host);
        $this->assertArrayHasKey('scanprogresstotal', $host);
        $this->assertArrayHasKey('numchecksconsidered', $host);
        $this->assertArrayHasKey('totalchecksconsidered', $host);
        $this->assertArrayHasKey('severitycount', $host);
        $this->assertArrayHasKey('0', $host['severitycount']);
    }

    /**
     * @depends testScanList
     */
    public function testScanPause($scan)
    {
        $scan = self::$client->scanPause($scan['uuid']);

        sleep(4);

        $this->assertArrayHasKey('readableName', $scan);
        $this->assertArrayHasKey('start_time', $scan);
        $this->assertArrayHasKey('status', $scan);
        $this->assertArrayHasKey('name', $scan);
        $this->assertArrayHasKey('uuid', $scan);
        $this->assertArrayHasKey('shared', $scan);
        $this->assertArrayHasKey('user_permissions', $scan);
        $this->assertArrayHasKey('default_permisssions', $scan);
        $this->assertArrayHasKey('owner', $scan);
        $this->assertArrayHasKey('owner_id', $scan);
        $this->assertArrayHasKey('last_modification_date', $scan);
        $this->assertArrayHasKey('creation_date', $scan);
        $this->assertArrayHasKey('type', $scan);
        $this->assertArrayHasKey('id', $scan);
    }

    /**
     * @depends testScanList
     */
    public function testScanResume($scan)
    {
        $scan = self::$client->scanResume($scan['uuid']);

        sleep(4);

        $this->assertArrayHasKey('readableName', $scan);
        $this->assertArrayHasKey('start_time', $scan);
        $this->assertArrayHasKey('status', $scan);
        $this->assertArrayHasKey('name', $scan);
        $this->assertArrayHasKey('uuid', $scan);
        $this->assertArrayHasKey('shared', $scan);
        $this->assertArrayHasKey('user_permissions', $scan);
        $this->assertArrayHasKey('default_permisssions', $scan);
        $this->assertArrayHasKey('owner', $scan);
        $this->assertArrayHasKey('owner_id', $scan);
        $this->assertArrayHasKey('last_modification_date', $scan);
        $this->assertArrayHasKey('creation_date', $scan);
        $this->assertArrayHasKey('type', $scan);
        $this->assertArrayHasKey('id', $scan);
    }

    /**
     * @depends testScanList
     */
    public function testScanStop($scan)
    {
        $scan = self::$client->scanStop($scan['uuid']);

        // Wait for the scan to stop so we can delete the report.
        sleep(10);

        $this->assertArrayHasKey('readableName', $scan);
        $this->assertArrayHasKey('start_time', $scan);
        $this->assertArrayHasKey('status', $scan);
        $this->assertArrayHasKey('name', $scan);
        $this->assertArrayHasKey('uuid', $scan);
        $this->assertArrayHasKey('shared', $scan);
        $this->assertArrayHasKey('user_permissions', $scan);
        $this->assertArrayHasKey('default_permisssions', $scan);
        $this->assertArrayHasKey('owner', $scan);
        $this->assertArrayHasKey('owner_id', $scan);
        $this->assertArrayHasKey('last_modification_date', $scan);
        $this->assertArrayHasKey('creation_date', $scan);
        $this->assertArrayHasKey('type', $scan);
        $this->assertArrayHasKey('id', $scan);
    }

    /**
     * @depends testTemplateNew
     */
    public function testTemplateDelete($template)
    {
        $template = self::$client->templateDelete($template['name']);

        $this->assertArrayHasKey('readableName', $template);
        $this->assertArrayHasKey('policy_id', $template);
        $this->assertArrayHasKey('name', $template);
        $this->assertArrayHasKey('startTime', $template);
        $this->assertArrayHasKey('rRules', $template);
        $this->assertArrayHasKey('target', $template);
        $this->assertArrayHasKey('owner', $template);
    }

    /**
     * @depends testReportList
     */
    public function testReportDownload($report)
    {
        $xml = self::$client->reportDownload($report['name']);

        $doc = @simplexml_load_string($xml);

        $this->assertInstanceOf('SimpleXMLElement', $doc);
    }

    /**
     * @depends testReportList
     */
    public function testReportDelete($report)
    {
        $report = self::$client->reportDelete($report['name']);

        $this->assertArrayHasKey('name', $report);
    }
}
 