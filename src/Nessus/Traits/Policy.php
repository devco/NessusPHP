<?php

namespace Nessus\Traits;

trait Policy
{
    public function policyList()
    {
        $response = $this->connect('policy/list');

        $policies = array();

        if (isset($response['policies']['policy'])) {
            if (isset($response['policies']['policy']['0'])) {
                foreach ($response['policies']['policy'] as $policy) {
                    $policies[] = [
                        'policyid' => $policy['policyid'],
                        'policyname' => $policy['policyname']
                    ];
                }
            } else {
                $policy = $response['policies']['policy'];

                $policies[] = [
                    'policyid' => $policy['policyid'],
                    'policyname' => $policy['policyname']
                ];
            }
        }

        return $policies;
    }
} 