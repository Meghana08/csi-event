<?php

namespace App\Jobs;

use App\Jobs\Job;
use GuzzleHttp\Client;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRegisterSms extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $id;
    protected $email;
    protected $mobile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $email, $mobile)
    {
        $this->id = $id;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        $smstext = "Thank you for submitting your CSI Membership Application. Your AID is {$this->id}, please check your Primary Email ID {$this->email} for further details. Computer Society of India";
        
        $client = new Client();
        $res = $client->request('POST', 'http://203.212.70.200/smpp/sendsms', [
            'form_params' => [
                'username' => 'bhartiv', 
                'password' => 'del12345',
                'from' => 'BVICAM',
                'to' => $this->mobile,
                'text' => $smstext
            ]
        ]);
    }

/*    public function curl2($url, $fields = array(), $auth = false) {
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        
        if($auth){
            curl_setopt($curl, CURLOPT_USERPWD, "$auth");
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }
    
        if($fields){        
            $fields_string = http_build_query($fields);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        }
        
        //var_dump($curl);
        
        $response = curl_exec($curl);
        //$headers_information = curl_getinfo($curl, 'CURLINFO_CONTENT_TYPE');
        //var_dump($headers_information);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header_string = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        
        $header_rows = explode(PHP_EOL, $header_string);
        $header_rows = array_filter($header_rows, trim);
        foreach((array)$header_rows as $hr){
            $colonpos = strpos($hr, ':');
            $key = $colonpos !== false ? substr($hr, 0, $colonpos) : (int)$i++;
            $headers[$key] = $colonpos !== false ? trim(substr($hr, $colonpos+1)) : $hr;
        }
        foreach((array)$headers as $key => $val){
            $vals = explode(';', $val);
            if(count($vals) >= 2){
                unset($headers[$key]);
                foreach($vals as $vk => $vv){
                    $equalpos = strpos($vv, '=');
                    $vkey = $equalpos !== false ? trim(substr($vv, 0, $equalpos)) : (int)$j++;
                    $headers[$key][$vkey] = $equalpos !== false ? trim(substr($vv, $equalpos+1)) : $vv;
                }
            }
        }
        //print_rr($headers);
        curl_close($curl);
        return array($body, $headers);
    }*/
}
