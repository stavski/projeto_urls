<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function formLogin() 
    {
        return view('auth.login');
    }

    public function logar(LoginRequest $request)
    {
        try {
            $dados = ['login'=>$request->login, 'password'=>$request->password];

            if (Auth::attempt($dados)) {
                return redirect()->intended('/home');
            } else {
                return redirect()->back()->with('warning', 'Usuário ou senha incorreto!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('warning', 'Erro!');
        }
    }
}
