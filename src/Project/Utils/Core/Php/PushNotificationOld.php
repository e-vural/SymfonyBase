<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 23.02.2018
 * Time: 14:48
 */

namespace Project\Utils\Core\Php;


class PushNotificationOld
{

    // (Android)API access key from Google API's Console.
    private static $API_ACCESS_KEY = '';
    // (iOS) Private key's passphrase.
    private static $passphrase = 'joashp';
    // (Windows Phone 8) The name of our push channel.
    private static $channelName = "joashp";

    // Change the above three vriables as per your app.
    public function __construct() {

    }


    public function prepareNotificationData($title,$body,$extra = array(),$actions = array(),$vibrate = 1, $vibrationPattern = [2000, 1000, 500, 500]){


        /*$message = array(
            'title' => $data['title'],
            'message' => $data['desc'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'extra' => $data['extra'],
            "actions" => [
                ["icon" => "emailGuests", "title" => "EMAIL GUESTS", "callback" => "app.emailGuests", "foreground" => true],
                ["icon" => "snooze", "title" => "SNOOZE", "callback" => "app.snooze", "foreground" => false]
            ],
            "vibrationPattern" => [2000, 1000, 500, 500]

        );*/

        //data adında array oluşturduk. Başlık ve açıklamayı içine aktardık.
        $data['title'] = $title;
        $data['body'] = $body;
        $data['actions'] = $actions;
        $data['vibrate'] = $vibrate;
        $data['vibrationPattern'] = $vibrationPattern;

//        $array = array('url' => $url);
//        $array = array_merge($array,$extra);

        //Mobil uygulamada neresi açılacak onun yolu
        $data['tag'] = $extra;//ekstranın içine kendi gödnereceğimiz dataları yazıyoruz. Örnek url => tıklanıca mobilde neresi açılacak diye bir parametre. Uygulamada bu parametreyi çekip yönlendirme yapabilirisin

        return $data;

    }


    public function prepareNotificationActionButton($title,$callback,$foreground = true,$icon = null){

        //$foreground uygulama tamamen kapalı iken tıklanınca açar.false olursa uygulama arkaplanda çalışıyorsa uygulamayı açmadan işlem yaptırır
        return ["icon" => $icon, "title" => $title, "callback" => $callback, "foreground" => $foreground];

    }

    public function sendNotificationFromToken(Device $device,$data){



        if(!is_object($device)){

            return false;
        }

        $token = $device;
        $deviceToken = $token->getPushToken();
        $osType = $token->getOsType();

        $response = "";
        if(mb_strtolower($osType) == "android"){
            $response = $this->android($data,array($deviceToken));
        }else{
//            $response = $this->iOS($data,$deviceToken);

        }


        return (array) $response;


    }

    // Sends Push notification for Android users
    public function sendAndoid($data, $reg_ids,$androidTokenIds = array()) {
        //Google tek seferde 1000 adet bildirim gönderebilir. O yüzden arrayımizi 1000'erli guruplara bölüyoruz.
        $array_chunk =  array_chunk($reg_ids,1000);
        $androidTokenIdsChunk = array_chunk($androidTokenIds,1000);
        $response = [];
        $error_tokens = [];
        $error_token_ids = [];
        $success_token_ids = [];

        echo "<pre>";
        print_r($reg_ids);
        foreach ($array_chunk as $key => $value) {

            $r = $this->android($data,$value);

            $re = json_decode($r,true);
            $results = $re["results"];
//            dump($data);
//            dump($value);
//            dump($re);
//            dump($results);
//            dump($androidTokenIdsChunk);

            print_r($results);
            echo "<hr>";

            foreach ($results as $key2 => $result) {


//                if(array_key_exists("error",$result)){
//                    array_push($error_token_ids,$androidTokenIdsChunk[$key][$key2]);
//                }else if(array_key_exists("message_id",$result)){
//                    array_push($success_token_ids,$androidTokenIdsChunk[$key][$key2]);
//
//                }

            }
//
            $response[$key]["error_token_ids"] = $error_token_ids ;
        }



//        echo "push gimişolmaslı";

        exit;


        return $response;
    }


    // Sends Push notification for Android users
    public function android($data, $reg_id) {

        $url = 'https://android.googleapis.com/gcm/send';

        $message = array(
            'title' => $data['title'],
            'message' => $data['body'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'tag' => $data["tag"]
//            "actions" => [
//                ["icon" => "emailGuests", "title" => "EMAIL GUESTS", "callback" => "app.emailGuests", "foreground" => true],
//                ["icon" => "snooze", "title" => "SNOOZE", "callback" => "app.snooze", "foreground" => false]
//            ],
//            "vibrationPattern" => [2000, 1000, 500, 500]
        );

        $headers = array(
            'Authorization: key=' .self::$API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        dump($data);
        $fields = array(
            'registration_ids' => array($reg_id),
            'notification' => $data,
        );


        return $this->useCurl($url, $headers, json_encode($fields));
    }

    // Sends Push's toast notification for Windows Phone 8 users
    public function WP($data, $uri) {
        $delay = 2;
        $msg =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
            "<wp:Notification xmlns:wp=\"WPNotification\">" .
            "<wp:Toast>" .
            "<wp:Text1>".htmlspecialchars($data['mtitle'])."</wp:Text1>" .
            "<wp:Text2>".htmlspecialchars($data['mdesc'])."</wp:Text2>" .
            "</wp:Toast>" .
            "</wp:Notification>";

        $sendedheaders =  array(
            'Content-Type: text/xml',
            'Accept: application/*',
            'X-WindowsPhone-Target: toast',
            "X-NotificationClass: $delay"
        );

        $response = $this->useCurl($uri, $sendedheaders, $msg);

        $result = array();
        foreach(explode("\n", $response) as $line) {
            $tab = explode(":", $line, 2);
            if (count($tab) == 2)
                $result[$tab[0]] = trim($tab[1]);
        }

        return $result;
    }

    // Sends Push notification for iOS users
    public function iOS($data, $devicetoken) {
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195', $err,
            $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['mtitle'],
                'body' => $data['mdesc'],
            ),
            'sound' => 'default'
        );
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered' . PHP_EOL;
    }

    // Curl
    public function useCurl( $url, $headers, $fields = null) {
        // Open connection
        $ch = curl_init();
//        dump($url);
//        exit;
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            return $result;
        }
    }

}
