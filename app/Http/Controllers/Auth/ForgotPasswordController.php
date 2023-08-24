<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
       $this->validateEmail($request);
       $this->validateRecaptcha($request);

       // Valida Usuário Ativo

       $email = $request->only('email')['email'];

        $usuario = User::where('email', $email)->first();

        if(isset($usuario)){
            if($usuario->status == 0){
                
                return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('Sua conta está inativa. Você recebeu um link de liberação por email. Caso não tenha recebido, entrar em contato com '.env('SEDH_EMAIL').' e solicitar a liberação.')]);
            }
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
       $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

       return $response == Password::RESET_LINK_SENT
       ? $this->sendResetLinkResponse($request, $response)
       : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function validateRecaptcha(Request $request)
    {
       $this->validate($request, 
        [
            'g-recaptcha-response' => 'required|valida_recaptcha'
        ],
        [
            'g-recaptcha-response.required' => 'Requisição Inválida',
            'g-recaptcha-response.valida_recaptcha' => 'Erro na Requisição' 
        ]);
    }

}
