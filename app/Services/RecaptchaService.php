<?php
namespace App\Services;

use Exception;
use Illuminate\Http\{Request,Response};
use Illuminate\Support\Facades\{Log,Http};

class RecaptchaService {
    
    /**
     * verify google recaptcha response from api
     *
     * @param Request $request
     * @return bool
    */
    public function verifyCaptcha(Request $request){
        try{
            $result = $this->callVerifyApi($this->dataMapping($request->validated('recaptcha'),$request->ip()));
            if($result->status() != Response::HTTP_OK) return false;
            $response = json_decode($result->body() , true);
            return $response['success'] ?? false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    /**
     * call curl request to google recaptcha api
     *
     * @param array $data
     * @return \Illuminate\Http\Client\Response 
    */
    public function callVerifyApi(array $data){
        return Http::asForm()->acceptJson()->post(config('services.recaptcha.origin') . config('services.recaptcha.verifyAPi') , $data);
    }

    /**
     * prepare data for api call
     *
     * @param ?string $recaptcha
     * @param ?string $ip
     * @return array
    */
    public function dataMapping(?string $recaptcha , ?string $ip)
    {
        return [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha,
            'remoteip' => $ip,
        ];
    }
}