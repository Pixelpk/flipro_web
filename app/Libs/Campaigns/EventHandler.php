<?php
namespace App\Libs\Campaigns;
use App\Libs\Campaigns;
use App\Libs\Interfaces\Event;
use App\Models\CampaignEventLog;
use Exception;
use Illuminate\Support\Facades\Log;

class EventHandler {
    public $event;
    public $data;
    public function __construct(Event $event, $data)
    {
        $this->event = $event;
        $this->data = $data;
        
    }

    public function attempt(){
        try{
            $this->event->execute($this->data);
        }
        catch(Exception $ex){
            $this->error = $ex;
        }
        finally{
            if($this->event->hasExecuted()){
                // Log::alert($this->event->hasError());
                if($this->event->hasError()){
                    $this->data['failed'] = true;
                    $this->data['error_message'] = $this->event->hasError()->getMessage();
                    Log::error($this->event->hasError());
                }
                CampaignEventLog::forceCreate($this->data);
            }
        }
    }
}