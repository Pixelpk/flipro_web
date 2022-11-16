<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Configuration;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    protected $apiClient;
    
    public function __construct()
    {
        $this->apiClient = new ApiClient($this->getConfiguration());
    }

    public function getConfiguration()
    {
        $config = new Configuration();
        $config->setHost('https://demo.docusign.net/restapi');
        $config->addDefaultHeader("X-DocuSign-Authentication", $this->getAuthHeader());
        return $config;

    }

    protected function getAuthHeader()
    {
        return json_encode([
            'Username' => 'ali_haider@pixelpk.com',
            'Password' => '19701976aA@',
            'IntegratorKey' => '6da94524-ca32-4a5c-a54f-075590447ceb',
        ]);
    }

    public function getStatus(Request $request = null, Contract $contract)
    {
        $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($this->apiClient);
        $results = $envelope_api->getEnvelope('f01cef41-5b6b-4dc4-afaf-2ccc2ac5d180', $contract->envelope_id);
        return json_decode($results);
    }

    public function updateStatus(Request $request = null, Contract $contract)
    {
      	if($contract->envelope_id){
            $status = $this->getStatus(null, $contract);
            $contract->status = $status->status;
            $contract->update();
        }
        return [
            'message' => 'success',
            'data' => $status ?? 'new'
        ];
    }
}
