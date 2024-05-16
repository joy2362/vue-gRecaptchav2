<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecaptchaRequest;
use App\Services\RecaptchaService;

class FormController extends Controller
{
    public function __construct( public RecaptchaService $recaptcha )
    {
        
    }
    public function store(RecaptchaRequest $request){

        if($request->validated('submit') > 2 && !$this->recaptcha->verifyCaptcha($request)){
            return response()->json([
                'error' => "Recaptcha is required",
                'errors' => [
                    'recaptcha' =>[
                        "Recaptcha is required"
                    ]
                ],
                'success' => false,
            ] , 422);
        }
        
        return response()->json([
            'success' => true,
            'message' => "form submit successfully",
            'data' => $request->all(),
        ]);
    }
}