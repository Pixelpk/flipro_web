<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\UserSmtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webklex\IMAP\Facades\Client;

class  EmailInboxController extends Controller
{
    private $server;

    public function construct($server = false)
    {
        $this->server = $server;
    }

    public function cron()
    {
        $servers = UserSmtp::all();
       
        foreach($servers as $server)
        {
            $client = Client::make([
                'host'          => $server->incomming_server,
                'port'          => $server->incomming_port,
                'encryption'    => $server->auth,
                'validate_cert' => false,
                'username'      => $server->username,
                'password'      => $server->password,
                'protocol'      => $server->authentication_type
            ]);
    
            $client->connect();
        
    
            if(!$client->getFolder('FLIPROMOVED')) $client->createFolder('FLIPROMOVED');
    
            $folders = $client->getFolders();
         
            
            foreach($folders as $folder){
                if($folder->name == 'INBOX' || $folder->name == 'Sent'){
                    $messages = $folder->messages()->all()->get();
                    foreach($messages as $message){
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
                        $from = $fromMatch[0][0] ?? $from;
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
    }

    public function fetchSinge()
    {
        if($this->server){
            $client = Client::make([
                'host'          => $this->server->incomming_server,
                'port'          => $this->server->incomming_port,
                'encryption'    => $this->server->auth,
                'validate_cert' => false,
                'username'      => $this->server->username,
                'password'      => $this->server->password,
                'protocol'      => $this->server->authentication_type
            ]);
    
            $client->connect();
    
            if(!$client->getFolder('FLIPROMOVED')) $client->createFolder('FLIPROMOVED');
    
            $folders = $client->getFolders();
            
            foreach($folders as $folder){
                if($folder->name == 'INBOX' || $folder->name == 'Sent'){
                    $messages = $folder->messages()->all()->get();
                    foreach($messages as $message){
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
    
                        if($moved){
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
                        }
    
                    }
                }
            }
        }
    }
}
