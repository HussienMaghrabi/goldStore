<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Store;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{

 # --------------------successResponse------------------
 public function successResponse($data, $message = NULL)
 {
      $response = array(
        'status'  => TRUE,
        'message' => $message,
        'data'    => $data
      );
      return response()->json($response, 200);
  }


  # --------------------errorResponse------------------
  public function errorResponse($errors , $data = NULL)
  {
      $response = array(
        'status'  => FALSE,
        'message' => $errors,
        'data'    => $data
      );
      return response()->json($response);
  }



  #------------------ format error----------------
  public function formatErrors($errors)
    {
        $stringError = "";
        for ($i=0; $i < count($errors->all()); $i++) {
          $stringError = $stringError . $errors->all()[$i];
          if($i != count($errors->all())-1){
            $stringError = $stringError . '\n';
          }
        }
        return $stringError;
    }

    #------------------ lang ----------------
    public function lang()
    {
        App::setLocale(request()->header('lang'));
        if (request()->header('lang'))
        {
            return request()->header('lang');
        }
        return 'ar';
    }

    #------------------ Auth ----------------
    public function auth()
    {
        if (request()->header('Authorization'))
        {
            $user = Token::where('api_token', request()->header('Authorization'))->first();

            if ($user)
            {
                return $user->user_id;
            }

        }
        return 0;
    }
# -------------------------------------------------
  public function uploadBase64($base64, $path, $extension = 'jpeg')
  {
      $fileBaseContent = base64_decode($base64);
      $fileName = str_random(10).'_'.time().'.'.$extension;
      $file = $path.'/'.$fileName;
      Storage::disk('public')->put('uploads/'.$file, $fileBaseContent);
      return 'uploads/' . $file;
  }

# -------------------------------------------------
  public function upload64($base64, $path, $extension = 'mp4')
  {
      $fileBaseContent = base64_decode($base64);
      $fileName = str_random(10).'_'.time().'.'.$extension;
      $file = $path.'/'.$fileName;
      Storage::disk('public')->put('uploads/'.$file, $fileBaseContent);
      return 'uploads/' . $file;
  }



    # -------------------------------------------------
    public function sendSMS($phone, $sms)
    {
        $url = 'http://www.kwjawsms.com/smsgateway/services/messaging.asmx/Http_SendSMS?username=GoldStore&password=P@ssw0rd@@&customerid=391&sendertext=V.I.P&messagebody='.$sms.'&recipientnumbers='.$phone.'&defdate=&isblink=false&isflash=false';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec ($ch);
        curl_close ($ch);
    }
}
