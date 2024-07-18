<?php
namespace App\Channels;

use Exception;
use Illuminate\Support\Facades\Log;

class Releans
{

    protected $sender_id;
    protected $authorize;
    protected $app_id;
    protected $authorization;
    public function __construct(){
        $this->sender_id = config('services.releans.sender_id');
        $this->authorize = 'Authorization: Bearer '.config('services.releans.authorize');
        $this->app_id = config('services.onesignal.app_id');
        $this->authorization = 'Authorization: Basic '.config('services.onesignal.auth_key');
    }


    public function send($notifiable, $notification)
    {
        $config = config('services.releans');

        $curl = curl_init();

        $from = $this->sender_id;
        $to = $notifiable->routeNotificationForNexmo($notification);
        $message = $notification->toReleans($notifiable);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.releans.com/v2/message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "sender=$from&mobile=$to&content=$message",
            CURLOPT_HTTPHEADER => array($this->authorize),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        Log::debug('Releans  event', (array) $response);
        return $response;
    }
}
