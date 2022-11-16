<?php

namespace App\Http\Livewire\Widget;

use App\Models\Email;
use App\Models\Lead;
use App\Models\UserSmtp;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use PHPMailer\PHPMailer\PHPMailer;

class LiveSendEmailWidget extends Component
{

    use WithFileUploads;

    public $attachments;
    public $replyMessage;
    public $subject;
    public $to;
    public $emailSettings;
    public $user;



    protected $rules = [
        'to' => 'required|email',
        'subject' => 'required',
        'replyMessage' => 'required',
    ];

    protected $validationAttributes = [
        'replyMessage' => 'email body'
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->emailSettings = UserSmtp::where('user_id', Auth::id())->first();
        if(!$this->emailSettings){
            return redirect(url('/settings'));
        }
    }

    public function send()
    {
        dd($this->replyMessage);
        $this->validate();
        $messageId = uniqid();
        $emailSettings = $this->emailSettings;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $emailSettings->outgoing_server;
        $mail->SMTPAuth = true;
        $mail->Username = $emailSettings->username;
        $mail->Password = $emailSettings->password;
        $mail->SMTPSecure = null;
        $mail->Port = 25;

        $mail->setFrom($emailSettings->username, $emailSettings->sender_name);
        $mail->addAddress($this->to);
        $mail->isHTML(true);

        $mail->Subject = $this->subject;

        $mail->Body = $this->replyMessage;

        $attachments = [];

        if($this->attachments){
            foreach($this->attachments as $file){
                $originalName = $file->getClientOriginalName();
                $stored = $file->store($messageId, 'attachments');
                $attachments[] = [
                    'name' => $originalName,
                    'path' => $stored,
                    'content_type' => $file->getMimeType()
                ];
                $mail->addAttachment(storage_path('app/attachments/'.$stored), $originalName);
            }
        }

        try{
            $mail->send();
            $lead = Lead::where('email', $this->to)->first();
            Email::forceCreate([
                'subject' => "RE:" .  $this->subject,
                'message' => $this->replyMessage,
                'from' => $emailSettings->username,
                'to' => $this->to,
                'spf' => 'pass',
                'dkim' => 'pass',
                'message_id' => $messageId,
                'user_id' => Auth::id(),
                'lead_id' => $lead ? $lead->id : null,
                'email_date' => date('Y-m-d H:i:s'),
                'starred' => 0,
                'name' => $this->user->name,
                'read' => 1,
                'route' => 'outgoing',
                'attachments' => json_encode($attachments)
            ]);

            $this->dispatchBrowserEvent('alert', [
                'title'=> "Success",
                'text'=> 'Email sent successfully',
                'type'=> "success",
                'confirmButtonClass'=> 'btn btn-primary',
                'buttonsStyling'=> false,
            ]);
            return redirect('/inbox');
        }
        catch (\PHPMailer\PHPMailer\Exception $ex){
            if($ex->getCode() == 2){
                $this->dispatchBrowserEvent('alert', [
                    'title'=> "Error",
                    'text'=> 'There was an error sending email please check your email settings',
                    'type'=> "error",
                    'confirmButtonClass'=> 'btn btn-primary',
                    'buttonsStyling'=> false,
                ]);
            }
            if($ex->getCode() == 1){
                $this->dispatchBrowserEvent('alert', [
                    'title'=> "Error",
                    'text'=> 'Sender Hourly Bounce Limit Exceeded. Please contact email hosting provider',
                    'type'=> "error",
                    'confirmButtonClass'=> 'btn btn-primary',
                    'buttonsStyling'=> false,
                ]);
            }
        }
    }


    public function render()
    {
        return view('livewire.widget.live-send-email-widget');
    }
}
