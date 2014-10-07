<?php

namespace Nessus\Traits\Scan;

trait Template
{
    /**
     * @param string $templateName The template's name.
     * @param integer $policyId The policy id to use.
     * @param string $target The target(s). Can be a comma separated list of urls or ip addresses (including subnets).
     * @param string $startTime Time stamp: YYYYMMDDTHHIISS+0000 . e.g. 20140101T103000+1000
     * @param string $freq See Page 48 of http://static.tenable.com/documentation/nessus_5.0_XMLRPC_protocol_guide.pdf
     */
    public function templateNew($templateName, $policyId, $target, $startTime, $freq = 'FREQ=ONETIME')
    {
        $fields = array(
            'template_name' => $templateName,
            'rRules'        => $freq,
            'startTime'     => $startTime,
            'policy_id'     => $policyId,
            'target'        => $target
        );

        $response = $this->connect('scan/template/new', $fields);

        if (isset($response['template'])) {
            return [
                'readableName' => $response['template']['readableName'],
                'policy_id' => $response['template']['policy_id'],
                'name' => $response['template']['name'],
                'startTime' => $response['template']['startTime'],
                'rRules' => isset($response['template']['rRules']) ? $response['template']['rRules'] : null,
                'target' => $response['template']['target'],
                'owner' => $response['template']['owner']
            ];
        }
    }

    public function templateList()
    {
        $response = $this->connect('schedule/list');
        $templates = [];

        foreach ($response as $template) {
            $templates[] = [
                'name' => $template['name'],
                'policy_name' => $template['policy_name'],
                'type' => $template['type'],
                'rrules' => isset($template['rrules']) ? $template['rrules'] : null,
                'starttime' => $template['starttime'],
                'uuid' => $template['uuid'],
                'owner' => $template['owner'],
                'shared' => $template['shared'],
                'user_permissions' => $template['user_permissions'],
                'timestamp' => $template['timestamp'],
                'last_modification_date' => $template['last_modification_date'],
                'creation_date' => $template['creation_date'],
                'owner_id' => $template['owner_id'],
                'id' => $template['id']
            ];
        }

        return $templates;
    }

    /**
     * @param string $name Uuid of the template.
     */
    public function templateLaunch($name)
    {
        $fields = array(
            'template'  => $name,
        );

        $response = $this->connect('scan/template/launch', $fields);

        if (isset($response['scan'])) {
            return [
                'start_time' => $response['scan']['start_time'],
                'status' => $response['scan']['status'],
                'name' => $response['scan']['name'],
                'uuid' => $response['scan']['uuid'],
                'owner' => $response['scan']['owner'],
                'type' => $response['scan']['type'],
                'id' => $response['scan']['id']
            ];
        }
    }

    /**
     * @param string $name Uuid of the template.
     */
    public function templateDelete($name)
    {
        $fields = array(
            'template'  => $name,
        );

        $response = $this->connect('scan/template/delete', $fields);

        if (isset($response['template'])) {
            return [
                'readableName' => $response['template']['readableName'],
                'policy_id' => $response['template']['policy_id'],
                'name' => $response['template']['name'],
                'startTime' => $response['template']['startTime'],
                'rRules' => isset($response['template']['rRules']) ? $response['template']['rRules'] : null,
                'target' => $response['template']['target'],
                'owner' => $response['template']['owner']
            ];
        }
    }
} 