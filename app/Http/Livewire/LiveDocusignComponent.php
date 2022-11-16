<?php

namespace App\Http\Livewire;

use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Model\CarbonCopy;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\EnvelopeTemplate;
use DocuSign\eSign\Model\ModelList;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use Illuminate\Support\Facades\Storage;
use LaravelDocusign\Facades\DocuSign;
use Livewire\Component;

class LiveDocusignComponent extends Component
{

    private $apiClient;

    protected function getAuthHeader()
    {
        return json_encode([
            'Username' => 'ali_haider@pixelpk.com',
            'Password' => '19701976aA@',
            'IntegratorKey' => '6da94524-ca32-4a5c-a54f-075590447ceb',
        ]);
    }

    public function getConfiguration()
    {
        $config = new Configuration();
        $config->setHost('https://demo.docusign.net/restapi');
        $config->addDefaultHeader("X-DocuSign-Authentication", $this->getAuthHeader());
        return $config;

    }

    private function make_envelope($args)
    {
        # Create Template
        $templateResponse = $this->createTemplate();
        $templateId = array_values((array)$templateResponse)[0]['template_id'];


        # Create the envelope definition with the template_id
        $envelope_definition = new \DocuSign\eSign\Model\EnvelopeDefinition([
            'status' => 'sent',
            'template_id' => $templateId,
        ]);
        # Create the template role elements to connect the signer and cc recipients
        # to the template
        $signer = new \DocuSign\eSign\Model\TemplateRole([
            'email' => $args['signer_email'], 
            'name' => $args['signer_name'],
            'role_name' => 'signer',
        ]);
        # Add the TemplateRole objects to the envelope object
        $envelope_definition->setTemplateRoles([$signer]);
        return $envelope_definition;
    }

    private function worker($args)
    {
        $envelope_args = $args["envelope_args"];
        $envelope_definition = $this->make_envelope($envelope_args);
        $api_client = $this->apiClient;

        $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($api_client);
        $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
        $envelope_id = $results->getEnvelopeId();
        return ['envelope_id' => $envelope_id];
    }

    public function createTemplate()
    {
        $base64_file_content = base64_encode(Storage::disk('htmlTemplates')->get('test.pdf'));

        # Create the document model
        $document = new Document([# create the DocuSign document object
            'document_base64' => $base64_file_content,
            'name' => 'Lorem Ipsum', # can be different from actual file name
            'file_extension' => 'pdf', # many different document types are accepted
            'document_id' => '1', # a label used to reference the doc
        ]);

        # Create the signer recipient model
        # Since these are role definitions, no name/email:
        $signer = new Signer([
            'role_name' => 'signer', 
            'recipient_id' => "1", 
            'routing_order' => "1"
        ]);
        # create a cc recipient to receive a copy of the documents
        
        $sign_here = new SignHere([
            'document_id' => '1', 
            'anchor_string' => 'ST0008'
        ]);
        
        # Add the tabs model to the signer
        # The Tabs object wants arrays of the different field/tab types
        $signer->setTabs(new Tabs([
            'sign_here_tabs' => [$sign_here],
        ]));

        # Template object:
        $template_request = new EnvelopeTemplate([
            'description' => "Example template created via the API",
            'name' => 'new test template',
            'shared' => "false",
            'documents' => [$document], 'email_subject' => "Please sign this document",
            'recipients' => new Recipients([
                'signers' => [$signer]]),
            'status' => "created",
        ]);

        $client = DocuSign::create();
        return $client->get('templates')->createTemplate($template_request);
    }

    public function mount()
    {
        $this->apiClient = new ApiClient($this->getConfiguration());

        $args = [
            'account_id' => 'f01cef41-5b6b-4dc4-afaf-2ccc2ac5d180',
            'envelope_args' => [
                'template_id' => 'd1c74bf5-df76-49cb-a059-a5b47e7616a8',
                'signer_email' => 'ali@mailinator.com',
                'signer_name' => 'ali',
            ],
        ];

        dd($this->worker($args));
    }

    public function render()
    {
        return view('livewire.live-docusign-component');
    }
}
