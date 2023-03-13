<?php
namespace App\Libs\Campaigns\Events;

use App\Libs\Interfaces\Event;
use App\Models\EmailCampaign;
use App\Models\Lead;
use App\Models\UserSmtp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email implements Event
{
    use SoftDeletes;
    public $data;
    public $executed;
    public $error = false;
    public function execute($data)
    {
        $campaign = EmailCampaign::find($data['email_campaign_id'])->first();
        $emailSettings = UserSmtp::where('user_id', $campaign->user_id)->first();
        $lead = Lead::find($data['lead_id']);
        if(!$lead){
            $this->execute = true;
            return;
        }
        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = true;
            $mail->isSMTP();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = $emailSettings->outgoing_server;
            $mail->SMTPAuth = true;
            $mail->Username = $emailSettings->username;
            $mail->Password = $emailSettings->password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
    
            $mail->setFrom($emailSettings->username, $emailSettings->sender_name);
            $mail->addAddress($lead->email);
            $mail->isHTML(true);
    
            $mail->Subject = json_decode($data['data'])->subject;
            $mail->Body = json_decode($data['data'])->body;
    
            if ($mail->send()) {
                $this->executed = true;
            }
            else {
                $this->executed = true;
                $this->error = [
                    'could not send'
                ];
            }
        }
        catch(Exception $ex) {
            $this->executed = true;
            $this->error = $ex;
        }
    }

    public function hasExecuted()
    {
        return $this->executed;
    }

    public function hasError()
    {
        return $this->error;
    }

}
