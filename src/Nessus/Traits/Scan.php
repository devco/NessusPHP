<?php

namespace Nessus\Traits;

trait Scan
{
    public function scanList()
    {
        $response = $this->connect('scan/list');
        $scans = [];

        if (isset($response['scans']['scanList']['scan']['0'])) {
            foreach ($response['scans']['scanList']['scan'] as $scan) {
                $scans[] = [
                    'uuid' => $scan['uuid'],
                    'completion_current' => $scan['completion_current'],
                    'completion_total' => $scan['completion_total'],
                    'readableName' => $scan['readableName'],
                    'status' => $scan['status'],
                    'start_time' => $scan['start_time']
                ];
            }
        } else {
            $scan = $response['scans']['scanList']['scan'];

            if (isset($scan['uuid'])) {
                $scans[] = [
                    'uuid' => $scan['uuid'],
                    'completion_current' => $scan['completion_current'],
                    'completion_total' => $scan['completion_total'],
                    'readableName' => $scan['readableName'],
                    'status' => $scan['status'],
                    'start_time' => $scan['start_time']
                ];
            }
        }

        return $scans;
    }

    public function scanPause($uuid)
    {
        $fields = [
            'scan_uuid' => $uuid,
        ];

        $response = $this->connect('scan/pause', $fields);

        if (isset($response['scan'])) {
            $scan = $response['scan'];

            return [
                'readableName' => $scan['readableName'],
                'start_time' => $scan['start_time'],
                'status' => $scan['status'],
                'name' => $scan['name'],
                'uuid' => $scan['uuid'],
                'shared' => $scan['shared'],
                'user_permissions' => $scan['user_permissions'],
                'default_permisssions' => $scan['default_permisssions'],
                'owner' => $scan['owner'],
                'owner_id' => $scan['owner_id'],
                'last_modification_date' => $scan['last_modification_date'],
                'creation_date' => $scan['creation_date'],
                'type' => $scan['type'],
                'id' => $scan['id']
            ];
        }
    }

    public function scanResume($uuid)
    {
        $fields = [
            'scan_uuid' => $uuid,
        ];

        $response = $this->connect('scan/resume', $fields);

        if (isset($response['scan'])) {
            $scan = $response['scan'];

            return [
                'readableName' => $scan['readableName'],
                'start_time' => $scan['start_time'],
                'status' => $scan['status'],
                'name' => $scan['name'],
                'uuid' => $scan['uuid'],
                'shared' => $scan['shared'],
                'user_permissions' => $scan['user_permissions'],
                'default_permisssions' => $scan['default_permisssions'],
                'owner' => $scan['owner'],
                'owner_id' => $scan['owner_id'],
                'last_modification_date' => $scan['last_modification_date'],
                'creation_date' => $scan['creation_date'],
                'type' => $scan['type'],
                'id' => $scan['id']
            ];
        }
    }

    public function scanStop($uuid)
    {
        $fields = [
            'scan_uuid' => $uuid
        ];

        $response = $this->connect('scan/stop', $fields);

        if (isset($response['scan'])) {
            $scan = $response['scan'];

            return [
                'readableName' => $scan['readableName'],
                'start_time' => $scan['start_time'],
                'status' => $scan['status'],
                'name' => $scan['name'],
                'uuid' => $scan['uuid'],
                'shared' => $scan['shared'],
                'user_permissions' => $scan['user_permissions'],
                'default_permisssions' => $scan['default_permisssions'],
                'owner' => $scan['owner'],
                'owner_id' => $scan['owner_id'],
                'last_modification_date' => $scan['last_modification_date'],
                'creation_date' => $scan['creation_date'],
                'type' => $scan['type'],
                'id' => $scan['id']
            ];
        }
    }
}