<?php

namespace App\Http\Livewire;

use App\Models\Email;
use App\Models\UserSmtp;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Files\Disk;
use PHPMailer\PHPMailer\PHPMailer;
use Webklex\IMAP\Facades\Client;

class LiveInboxComponent extends Component
{
    use WithFileUploads, WithPagination;

    public $messages;
    public $openMessage;
    public $user;
    public $currentView = 'inbox';
    public $selected = [];
    public $show;
    public $replyMessage;
    public $attachments;
    public $searchTerm;
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->user = Auth::user();
        $this->getMessages();
        // $this->fetchEmails();

    }

    public function reply()
    {
        
        $messageId = uniqid();
        $emailSettings = UserSmtp::where('user_id', Auth::id())->first();
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $emailSettings->outgoing_server;
        $mail->SMTPAuth = true;
        $mail->Username = $emailSettings->username;
        $mail->Password = $emailSettings->password;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($emailSettings->username, $emailSettings->sender_name);
        $mail->addAddress($this->openMessage['from']);
        $mail->isHTML(true);

        $mail->Subject = "RE:" .  $this->openMessage['subject'];
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
            Email::forceCreate([
                'subject' => "RE:" .  $this->openMessage['subject'],
                'message' => $this->replyMessage ?? 'null',
                'from' => $emailSettings->username,
                'to' => $this->openMessage['from'],
                'spf' => 'pass',
                'dkim' => 'pass',
                'message_id' => $messageId,
                'user_id' => Auth::id(),
                'lead_id' => $this->openMessage['lead_id'],
                'email_date' => date('Y-m-d H:i:s'),
                'starred' => 0,
                'name' => $this->user->name,
                'read' => 1,
                'route' => 'outgoing',
                'attachments' => json_encode($attachments)
            ]);

            $this->dispatchBrowserEvent('alert', [
                'title'=> "Success",
                'text'=> 'Reply sent successfully',
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

    public function getMessages()
    {
        $this->messages = Email::where('user_id', $this->user->id)->orderByDesc('email_date')->get();
    }

    public function fetchEmails()
    {
       
      
        $server = UserSmtp::where('user_id', Auth::id())->first();
       
        if(!$server) return;
        $client = Client::make([
            'host'          => $server->incomming_server,
            'port'          => $server->incomming_port,
            'encryption'    => $server->auth,
            'verify_host'   => true,
            'username'      => $server->username,
            'password'      => $server->password,
            'protocol'      => $server->authentication_type
        ]);

      
     
        $client->connect();
        // dd($client);
        if(!$client->getFolder('FLIPROMOVED')) $client->createFolder('FLIPROMOVED');
     
        $folders = $client->getFolders();
       
        foreach($folders as $folder){
            if($folder->name == 'INBOX' || $folder->name == 'Sent'){
                
                $messages = $folder->messages()->all()->get();
              
                // $this->inbox = $messages;
                foreach($messages as $message)
                {
                    if($message->hasTextBody()){
                        $body = $message->getTextBody();
                    }elseif($message->hasHTMLBody()){
                        $body = $message->getHTMLBody();
                    }

                    $attributes = $message->getHeader()->getAttributes();
                    $subject = $message->getSubject()->toString();
                    $from = $message->getFrom()->toString() ?? '';
                    $messageId = $attributes['message_id']->toString() ?? '';
                    $to = $message->getTo()->toString() ?? '';
                    $spf = isset($attributes['received_spf']) ? $attributes['received_spf']->toString() : '';
                    $dkim = isset($attributes['dkim']) ? $attributes['dkim']->toString() : '';
                    $emailDate = $attributes['date']->toString() ?? '';

                    if(Email::where('message_id', $messageId)->first()){
                        $message->move('FLIPROMOVED');
                        continue;
                    }

                    $pattern = '/^[A-z]* [A-z]* [A-z]*/i';
                    preg_match_all($pattern, $from, $nameMatch);
                    if(count($nameMatch[0])){
                        $name = trim($nameMatch[0][0]);
                    }
                    $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
                    preg_match_all($pattern, $from, $fromMatch);
                    $from = $fromMatch[0][0];
                    preg_match_all($pattern, $to, $toMatch);
                    $to = $toMatch[0][0];

                    $moved = $message->move('FLIPROMOVED');

                    // if($moved){
                      
                        $email = Email::forceCreate([
                            'name' => $name ?? '',
                            'subject' => $subject,
                            'message' => $body,
                            'from' => $from,
                            'to' => $to,
                            'spf' => $spf,
                            'dkim' => $dkim,
                            'message_id' => $messageId,
                            'user_id' => 1,
                            'lead_id' => 1,
                            'email_date' => $emailDate,
                            'route' => $folder->name == 'INBOX' ? 'incomming' : 'outgoing'
                        ]);
                        $attachments = [];
                        foreach($message->getAttachments() as $attachment){
                            $path = $messageId . '/' . $attachment->getName();
                            Storage::disk('attachments')->put($path, $attachment->getContent());
                            $attachments[] = [
                                'name' => $attachment->getName(),
                                'path' => $path,
                                'content_type' => $attachment->getContentType()
                            ];
                        }
                        $email->attachments = json_encode($attachments);
                        $email->update();
                    // }

                }
            }
        }
     
    }

    public function open($message)
    {
        $this->openMessage = $message;
        $message = Email::withTrashed()->find($message['id']);
        $message->read = true;
        $message->update();
        $this->show = 'show';
    }

    public function setView($view)
    {
        $this->currentView = $view;
        $this->show = '';
        $this->selected = [];
    }

    public function getStarredProperty()
    {
        return Email::where(function($query){
            $query->where('subject', 'LIKE', '%'.$this->searchTerm.'%');
            $query->orWhere('message', 'LIKE', '%'.$this->searchTerm.'%');
        })->where('starred', 1)->where('user_id', Auth::id())->orderByDesc('email_date')->paginate(config('app.pageSize'));
    }

    public function getInboxProperty()
    {
        return Email::where(function($query){
            $query->where('subject', 'LIKE', '%'.$this->searchTerm.'%');
            $query->orWhere('message', 'LIKE', '%'.$this->searchTerm.'%');
        })->where('route', 'incomming')->where('user_id', Auth::id())->orderByDesc('email_date')->paginate(config('app.pageSize'));
    }

    public function getSentProperty()
    {
        return Email::where(function($query){
            $query->where('subject', 'LIKE', '%'.$this->searchTerm.'%');
            $query->orWhere('message', 'LIKE', '%'.$this->searchTerm.'%');
        })->where('route', 'outgoing')->where('user_id', Auth::id())->orderByDesc('email_date')->get();
    }

    public function getTrashedProperty()
    {
        return Email::onlyTrashed()->where('user_id', Auth::id())->orderByDesc('email_date')->where(function($query){
            $query->where('subject', 'LIKE', '%'.$this->searchTerm.'%');
            $query->orWhere('message', 'LIKE', '%'.$this->searchTerm.'%');
        })->get();
    }

    public function selection($message)
    {
        $message = (object)$message;
        if(isset($this->selected[$message->id])){
            unset($this->selected[$message->id]);
        }
        else {
            $this->selected[$message->id] = $message->id;
        }
    }

    public function star($message)
    {
        $message = Email::withTrashed()->find($message['id']);
        $message->starred = (boolean)!$message->starred;
        $message->update();
        $this->getMessages();
    }

    public function render()
    {
      
        return view('livewire.live-inbox-component');
    }

    public function removeBulk()
    {
        if($this->currentView == 'trash'){
            Email::whereIn('id', $this->selected)->forceDelete();
        } else {
            Email::whereIn('id', $this->selected)->delete();
        }
    }

    public function removeEmail($id)
    {
        Email::where('id', $id)->delete();
        $this->show = '';
    }


}