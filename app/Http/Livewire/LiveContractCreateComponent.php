<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\EventLog;
use App\Models\Project;
use PDF;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\EnvelopeTemplate;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LaravelDocusign\Facades\DocuSign;
use Livewire\Component;

class LiveContractCreateComponent extends Component
{
    public $title;
    public $body;
    protected $listeners = ['bodyChanged'];
    public $signatories = [];
    public $project;
    private $apiClient;
    private $templateId;
    public $contract;
    public $project_title;
    public $project_address;

    public function bodyChanged()
    {
        preg_match_all("/[sig:[a-zA-Z]{4,}(?: [a-zA-Z]+){0,2},[a-z|A-Z|0-9|.|_]*@[a-z|A-Z]*.[a-z|A-Z]*]/i", $this->body, $this->signatories);

    }

    public function create()
    {
        if(!$this->project){

            $this->validate([
                'title' => 'required',
                'project_title' => 'required',
                'project_address' => 'required',
                'body' => 'required',
                'signatories.0.*' => 'required',
                'signatories.*' => 'required'
            ], [
                'signatories.0.*' => 'Please add atleast one signatory using following santax [sig:name,email]',
                'signatories.*' => 'Please add atleast one signatory using following santax [sig:name,email]',
            ]);
            // dd('asd');

        }
        else{
            $this->validate([
                'title' => 'required',
                'body' => 'required',
                'signatories.0.*' => 'required',
                'signatories.*' => 'required'
            ], [
                'signatories.0.*' => 'Please add atleast one signatory using following santax [sig:name,email]',
                'signatories.*' => 'Please add atleast one signatory using following santax [sig:name,email]',
            ]);
        }
        // dd($this->signatories);
        $this->contract = Contract::forceCreate([
            'title' => $this->title,
            'project_id' => $this->project->id ?? 0,
            'signatories' => json_encode($this->signatories[0]),
            'contract_content' => $this->body,
            'data' => '',
            'user_id' => Auth::id(),
            'status' => 'new',
            'project_title' => $this->project_title ?? '',
            'project_address' => $this->project_address ?? '',
        ]);

        EventLog::forceCreate([
            'user_id' => Auth::user()->id,
            'project_id' => $this->project->id ?? 0,
            'description' =>  Auth::user()->name ." create new contract",
            'status' => 3,
        ]);

        $this->dispatchBrowserEvent('alert', [
            'title'=> $this->title,
            'text'=> 'Contract created successfully',
            'type'=> "success",
            'confirmButtonClass'=> 'btn btn-primary',
            'buttonsStyling'=> false,
        ]);
        $this->emit('refreshTable');

        $this->worker([
            'account_id' => 'f01cef41-5b6b-4dc4-afaf-2ccc2ac5d180',
            'envelope_args' => [
            ],
        ]);
        if(!$this->project){
            return redirect("/contracts/create/0");
        }
        return redirect("/projects/".$this->project->id);
    }

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

    private function worker($args)
    {
        $this->apiClient = new ApiClient($this->getConfiguration());
        $envelope_args = $args["envelope_args"];
        $envelope_definition = $this->makeEnvelope($envelope_args);
        $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($this->apiClient);
        $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
        $envelope_id = $results->getEnvelopeId();

        $this->contract->template_id = $this->templateId;
        $this->contract->envelope_id = $envelope_id;
        $this->contract->update();
        return ['envelope_id' => $envelope_id];
    }

    private function makeEnvelope($args)
    {
        $templateResponse = $this->createTemplate();
        $this->templateId = array_values((array)$templateResponse)[0]['template_id'];

        $envelope_definition = new \DocuSign\eSign\Model\EnvelopeDefinition([
            'status' => 'sent',
            'template_id' => $this->templateId,
        ]);
        $signers = [];
        foreach($this->signatories[0] as $key => $signatory){
            $anchor = $signatory;
            $signatory = explode(',', str_replace('[sig:', '', str_replace(']', '', $signatory)));
            $name = $signatory[0];
            $email = $signatory[1];

            $signer = [
                'email' => $email,
                'name' => $name,
                'role_name' => $anchor,
            ];
            $signers[] = new \DocuSign\eSign\Model\TemplateRole($signer);

        }
        $envelope_definition->setTemplateRoles($signers);
        return $envelope_definition;
    }

    public function createTemplate()
    {
        $pdf = PDF::loadView('pdf', [
            'data' => $this->body,
            'sig' => $this->signatories
        ])->stream();


        $base64Pdf = base64_encode($pdf);

        $document = new Document([
            'document_base64' => $base64Pdf,
            'name' => $this->title,
            'file_extension' => 'pdf',
            'document_id' => $this->contract->id,
        ]);

        $signatories = [];
        foreach($this->signatories[0] as $key => $signatory){
            $anchor = $signatory;
            $signatory = explode(',', str_replace('[sig:', '', str_replace(']', '', $signatory)));
            $signer = new Signer([
                'role_name' => $anchor,
                'recipient_id' => $key,
                'routing_order' => $key
            ]);
            $signHere = new SignHere([
                'document_id' => '1',
                'anchor_string' => $anchor
            ]);
            $signer->setTabs(new Tabs([
                'sign_here_tabs' => [$signHere],
            ]));
            $signatories[] = $signer;
        }



        $templateRequest = new EnvelopeTemplate([
            'description' => "Document signing required",
            'name' => $this->title,
            'shared' => "false",
            'documents' => [$document], 'email_subject' => $this->contract->title,
            'recipients' => new Recipients([
                'signers' => $signatories]),
            'status' => "created",
        ]);

        $client = DocuSign::create();
        return $client->get('templates')->createTemplate($templateRequest);
    }

    public function mount(Request $request, $project)
    {
        $project = Project::find($project);
        $this->apiClient = new ApiClient($this->getConfiguration());
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.live-contract-create-component');
    }
}
