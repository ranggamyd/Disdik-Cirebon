<?php

namespace App\MyClass;

use App\MyClass\Helper;
use App\AppModels\Setting;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class Whatsapp
{


    /**
     * Untuk mendapat Api Key Whatsapp
     * @return String
     */
    private static function getApiId()
    {
        //return Setting::get('wa_api_key');
        return Setting::get('whatsapp_api_id');
    }


    private static function getApiKey()
    {
        //return Setting::get('wa_api_key');
        return Setting::get('whatsapp_api_key');
    }



    /**
     * Untuk mendapat Api Server Whatsapp
     * @return String
     */
    private static function getApiServer()
    {
        //return "https://whatsapp.adiva.co.id/api/send"; // API Server
        // return Setting::get('whatsapp_api_server');
        // return 'https://wa.adiva.co.id';
        return \Setting::getValue('WHATSAPP_API_URL', 'http://103.242.105.85:50000/');
    }



    /**
     * Untuk kirim chat WhatsApp
     * @param Array $data
     *	- String to / phone 		=> Nomor Telepon
     *	- String text / message 	=> Isi Pesan
     * @return json
     */
    public static function sendChat($data)
    {
        $route = 'send';

        if ((array_key_exists('to', $data) || array_key_exists('phone', $data)) && (array_key_exists('text', $data) || array_key_exists('message', $data))) {
            // Phone number
            if (array_key_exists('to', $data)) {
                $phone = $data['to'];
            } elseif (array_key_exists('phone', $data)) {
                $phone = $data['phone'];
            }

            // Message
            if (array_key_exists('text', $data)) {
                $text = $data['text'];
            } elseif (array_key_exists('message', $data)) {
                $text = $data['message'];
            }

            if (empty(trim($text))) {
                $text = "NULL";
            }

            return Whatsapp::send($route, [
                // 'api_key'	=> self::getApiKey(),
                // 'api_id'    => self::getApiId(),
                'phone'        => $phone,
                'message'    => $text,
            ]);
        }
    }



    /**
     * 	Untuk kirim media WhatsApp
     * 	@param Array $data
     *	- String to / phone		=> Nomor Telepon
     *	- String path			=> Lokasi File
     *	- (Opsional) filename	=> Nama File
     * 	@return json
     */
    public static function sendMedia($data)
    {
        $route = 'send';

        if ((array_key_exists('to', $data) || array_key_exists('phone', $data)) && array_key_exists('path', $data)) {
            $dataSend = [];

            // Phone number
            if (array_key_exists('to', $data)) {
                $phone = $data['to'];
            } elseif (array_key_exists('phone', $data)) {
                $phone = $data['phone'];
            }
            $dataSend['phone'] = $phone;

            // File name
            if (array_key_exists('filename', $data)) {
                $dataSend['filename'] = $data['filename'];
            } else {
                $dataSend['filename'] = WhatsApp::mediaFilename($data['path']);
            }

            // File data
            $dataSend['filedata'] = base64_encode(File::get($data['path']));

            // File Mime
            $dataSend['mime'] = mime_content_type($data['path']);

            $dataSend['text'] = "File Penting";

            // Message
            if (array_key_exists('text', $data)) {
                $dataSend['text'] = $data['text'];
            } elseif (array_key_exists('message', $data)) {
                $dataSend['text'] = $data['message'];
            }

            // $dataSend['api_key'] = self::getApiKey();
            // $dataSend['api_id'] = self::getApiId();

            $dataSend['file'] = new \CURLFile($data['path'], mime_content_type($data['path']));

            return Whatsapp::send($route, $dataSend);
        }
    }



    /**
     *	Untuk get filename lewat link path
     *	@param String $path => Path File
     *	@return String Filename
     */
    private static function mediaFilename($path)
    {
        $uri = explode("/", $path);
        return $uri[count($uri) - 1];
    }



    /**
     * Untuk eksekusi pengiriman pesan/media
     * @param Array $sendData
     * @return json
     */
    private static function send($route, $sendData)
    {
        // Setting::increment('whatsapp_usage_count');
        // $ch = curl_init(Whatsapp::getApiServer());
        $ch = curl_init(Whatsapp::getApiServer() . $route);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendData);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}

/**

Send Chat Tutorial
example :
Whatsapp::sendChat([
	'to'	=> "6282316425264",
	'text'	=> "Text Pesan"
]);



Send Media Tutorial
example :
Whatsapp::sendMedia([
	'to'		=> "6282316425264",
	'path'		=> "invoice/INV0001.pdf",
	// Opsional
	'filename'	=> "namafile.pdf" // default nya nama file asal "INV0001.pdf";
]);
 */
