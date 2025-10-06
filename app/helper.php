<?php

use App\Models\Driver;
use App\Models\Policy;
use App\Models\Vehicle;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

function store_file($file, $path)
{
    $name = time() . $file->getClientOriginalName();
    return $value = $file->storeAs($path, $name, 'uploads');
}
function delete_file($file)
{
    if ($file != '' and !is_null($file) and Storage::disk('uploads')->exists($file)) {
        unlink('uploads/' . $file);
    }
}
function display_file($name)
{
    return asset('public/uploads') . '/' . $name;
}

function home_setting($key, $value = null)
{
    if (is_array($key)) {
        foreach ($key as $k => $v) {
            if (is_object($v)) {
                delete_file($option = HomeSetting::where('key', $k)->first()?->value);
                $v = store_file($v, 'home_setting');
            }
            HomeSetting::updateOrCreate(['key' => $k], ['value' => $v]);
        }
        return true;
    }
    $option = HomeSetting::where('key', $key)->first();
    if ($value) {
        $option->update([$key => $value]);
    }
    return $option?->value;
}

function badRequestResponse($en_message, $ar_message){
    return [
        'status' => 0,
        'statusCategory' => 'BadRequest',
        'message' => [
            'en' => $en_message,
            'ar' => $ar_message
        ],
        'data' => "",
        'desc' => 'Validation failed'
    ];
}

function successResponse($en_message, $ar_message, $data){
    return [
        'status' => 1,
        'statusCategory' => 'OK',
        'message' => [
            'en' => $en_message,
            'ar' => $ar_message
        ],
        'data' => $data,
        'desc' => ''
    ];
}

function internalServerErrorResponse($en_message, $ar_message){
    return [
        'status' => 0,
        'statusCategory' => 'InternalServerError',
        'message' => [
            'en' => $en_message,
            'ar' => $ar_message
        ],
        'data' => "",
        'desc' => ''
    ];
}

function uploadFileMail($stream){
    $headers = [
        "accept"=> "application/json",
        "authorization"=>"Zoho-enczapikey wSsVR61/rB/4Xah8nzz7I+88kQkHDlqlR0R+3wCjuXH7F/2T8sc+wRWcVlT0HfcYFDY4FTtDprIhmhsD0zcJ29gpylEICSiF9mqRe1U4J3x17qnvhDzMV2xfmhOPLIgNwghjmWBgEcAg+g==",
        "cache-control"=> "no-cache",
        "content-type"=> "application/json"
    ];

   $emailResponse = Http::withHeaders($headers)->post(
                            'https://api.zeptomail.com/v1.1/files?name=policy'.strtotime('now').'.pdf',
                            $stream
                        );
    $main_pdf = $emailResponse->json();
    \Log::error('PDF upload : ', $main_pdf);
    if(!empty($main_pdf['file_cache_key'])){
        return $main_pdf['file_cache_key'];
    } else{
        return false;
    }
}


function sendBuyPolicyEmail($to, $toName, $data,  $pdf, $pdf_oc = null){

    $files = [];

    $headers = [
        "accept"=> "application/json",
        "authorization"=>"Zoho-enczapikey wSsVR61/rB/4Xah8nzz7I+88kQkHDlqlR0R+3wCjuXH7F/2T8sc+wRWcVlT0HfcYFDY4FTtDprIhmhsD0zcJ29gpylEICSiF9mqRe1U4J3x17qnvhDzMV2xfmhOPLIgNwghjmWBgEcAg+g==",
        "cache-control"=> "no-cache",
        "content-type"=> "application/json"
    ];

    if($pdf_oc != null){
        $files = [
            [
                'name' => 'Policy'.strtotime('now').'.pdf',
                'content' => base64_encode(file_get_contents('/var/www/html/UIC-PHP/public/'. $pdf)),
                'mime_type' => 'plain/txt'
            ],
            [
                'name' => 'Policy'.strtotime('now').'.pdf',
                'content' => base64_encode(file_get_contents('/var/www/html/UIC-PHP/public/'. $pdf_oc)),
                'mime_type' => 'plain/txt'
            ]
        ];
    } else{
        $files = [
            [
                'name' => 'Policy'.strtotime('now').'.pdf',
                'content' => base64_encode(file_get_contents('/var/www/html/UIC-PHP/public/'. $pdf)),
                'mime_type' => 'plain/txt'
            ]
        ];

    }


    $params = [
        "mail_template_key" => "2d6f.6e9858ae3bbe52d4.k1.19c55af0-bdd6-11ef-aa30-525400f92481.193ddb2561f",
        "from" => [
            "address" => "noreply@uic.company",
            "name" => "noreply"
         ],
        "to" => [
               [
                  "email_address" => [
                     "address" => $to,
                     "name" => $toName
                  ]
               ]
        ],
        "cc" => [
               [
                  "email_address" => [
                     "address" => 'uic-online@uic.bh',
                     "name" => 'UIC'
                  ]
               ]
        ],
        "attachments"=> $files,
        "merge_info" => $data
   ];



   $emailResponse = Http::withHeaders($headers)->post('https://api.zeptomail.com/v1.1/email/template', $params);



}

function sendFailedPolicyEmail($to, $toName, $data){
    $policy = Policy::where('POL_REF_NO', $data['POL_REF_NO'])->first();
    $driver_res = Driver::find($policy->driver_id);
    $vehicle_res = Vehicle::find($policy->vehicle_id);
    $driver_gender = '1';
    if($driver_res->USRDR_GENDER == 'F'){
        $driver_gender = '2';
    }
    $headers = [
        "accept"=> "application/json",
        "authorization"=>"Zoho-enczapikey wSsVR61/rB/4Xah8nzz7I+88kQkHDlqlR0R+3wCjuXH7F/2T8sc+wRWcVlT0HfcYFDY4FTtDprIhmhsD0zcJ29gpylEICSiF9mqRe1U4J3x17qnvhDzMV2xfmhOPLIgNwghjmWBgEcAg+g==",
        "cache-control"=> "no-cache",
        "content-type"=> "application/json"
    ];



    $params = [
        "from" => [
            "address" => "transfer.failure@uic.company",
            "name" => "noreply"
         ],
        "to" => [
               [
                  "email_address" => [
                     "address" => $to,
                     "name" => $toName
                  ]
               ]
        ],
        "cc" => [
               [
                  "email_address" => [
                     "address" => 'ali.thamer@uic.bh',
                     "name" => 'UIC'
                  ],
                  "email_address" => [
                     "address" => 'mohamed.alrahim@uic.bh',
                     "name" => 'UIC'
                  ],
                  "email_address" => [
                     "address" => 'Mohamed.hamza@uic.bh',
                     "name" => 'UIC'
                  ]
               ]
        ],
        "subject" => "Unsaved Policy To Core ".$data['POL_REF_NO'],
        "htmlbody" => "
                <div style='padding-bottom: 5px;'><b>Request Body:</b></div>
                <div><b>".$data['request_body']."</b></div>
                <br /> <br /><hr /> <br /><br />

                <div style='padding-bottom: 5px;'><b>Core-System Response:</b></div>
                <div><b>".$data['response']."</b></div>
                <br /> <br /><hr /> <br /><br />
                <div><b>Vehicle Data:</b></div>
                <div>
                    <table style='border: 2px solid black; width: 100%;'>
                        <tr>
                            <td style='border: 1px solid black;'>Nationality</td>
                            <td style='border: 1px solid black;'>Class</td>
                            <td style='border: 1px solid black;'>RegnNo</td>
                            <td style='border: 1px solid black;'>PlateCode1</td>
                            <td style='border: 1px solid black;'>PlateCode2</td>
                            <td style='border: 1px solid black;'>PlateCode3</td>
                            <td style='border: 1px solid black;'>PlateCodeAr1</td>
                            <td style='border: 1px solid black;'>PlateCodeAr2</td>
                            <td style='border: 1px solid black;'>PlateCodeAr3</td>
                            <td style='border: 1px solid black;'>Type</td>
                            <td style='border: 1px solid black;'>AssrName</td>
                            <td style='border: 1px solid black;'>AssrIdNo</td>
                            <td style='border: 1px solid black;'>BodyType</td>
                            <td style='border: 1px solid black;'>Make</td>
                            <td style='border: 1px solid black;'>Model</td>
                            <td style='border: 1px solid black;'>Color</td>
                            <td style='border: 1px solid black;'>MakeYear</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleNationality</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleClass</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleRegnNo</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehiclePlateCode1</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehiclePlateCode2</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehiclePlateCode3</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehiclePlateCodeAr1</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehiclePlateCodeAr2</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehiclePlateCodeAr3</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleType</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleAssrName</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleAssrIdNo</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleBodyType</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleMake</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleModel</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleColor</td>
                            <td style='border: 1px solid black;'>$vehicle_res->vehicleMakeYear</td>
                        </tr>

                    </table>
                </div>

                <br /> <br /><hr /> <br /><br />
                <div><b>Driver Data:</b></div>
                <div>
                    <table style='border: 2px solid black; width: 100%;'>
                        <tr style='border: 1px solid black;'>
                            <td style='border: 1px solid black;'>Name</td>
                            <td style='border: 1px solid black;'>ID</td>
                            <td style='border: 1px solid black;'>Country Code</td>
                            <td style='border: 1px solid black;'>Mobile</td>
                            <td style='border: 1px solid black;'>Email</td>
                            <td style='border: 1px solid black;'>Nationality</td>
                            <td style='border: 1px solid black;'>Gender</td>
                            <td style='border: 1px solid black;'>Nationality ID</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid black;'>$driver_res->first_name $driver_res->middled_name </td>
                            <td style='border: 1px solid black;'>$driver_res->USRDR_ID_NO</td>
                            <td style='border: 1px solid black;'>$driver_res->USRDR_COUNTRY_CODE</td>
                            <td style='border: 1px solid black;'>$driver_res->USRDR_MOBILE</td>
                            <td style='border: 1px solid black;'>$driver_res->USRDR_EMAIL</td>
                            <td style='border: 1px solid black;'>$driver_res->USRDR_ID_NATIONALITY</td>
                            <td style='border: 1px solid black;'>$driver_gender</td>
                            <td style='border: 1px solid black;'>$driver_res->USRDR_ID_NATIONALITY</td>

                        </tr>

                    </table>
                </div>

                ",
   ];



   $emailResponse = Http::withHeaders($headers)->post('https://api.zeptomail.com/v1.1/email', $params);



}


function validateArabic(string $text){
    $ar_letters = [
        'ا', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ',
        'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي',
        'أ', 'إ', 'ؤ', 'ئ', 'ى', 'ة', 'ء',
        '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩','0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '،', '؛', '؟', '«', '»', 'ـ'
    ];
    for($i=0; $i<strlen($text); $i++){
        if(!in_array($text[$i], $ar_letters)){
          return false;
        }
        return true;
    }

}

function validateEnglish(string $text){

      $en_letters = [
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '!', '"', '#', '$', '%', '&', "'", '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~'
      ];

      for($i=0; $i<strlen($text); $i++){
          if(!in_array($text[$i], $en_letters)){
            return false;
          }
          return true;
      }
}
