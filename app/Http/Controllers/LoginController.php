<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Hash;
use Auth;

class LoginController extends Controller
{
    /*
        +---------------+--------------------------------------------------------------+--------------+
        | USUARIO_login | password                                                     | USUARIO_tipo |
        +---------------+--------------------------------------------------------------+--------------+
        | 2828282       | 282982829                                                    | EMPRESA      |
        | 282828www2    | 111                                                          | EMPRESA      |
        | huhdu         | 1111                                                         | PRESTADOR    |
        | rod           | $2y$10$j3v2EmwaiMPAMrV0b9QRoeSZKLOSexfbzWYI4bOHhGnKkRseNpMKC | EMPRESA      |
        +---------------+--------------------------------------------------------------+--------------+ 
     */
    public function index(Request $request){
        $resp = "";
        /*echo bcrypt('123');
        echo "<hr>";
        echo Hash::make('123');;*/
        if($request->isMethod("POST")){
            //pegar os dados
            $usuario = $request->input("usuario");//rod
            $senha = $request->input("password");//1122
            
            //https://laracasts.com/discuss/channels/general-discussion/authattempt-always-return-false
            //https://laracasts.com/discuss/channels/general-discussion/authattempt-always-returns-false
            //https://laracasts.com/discuss/channels/laravel/laravel-52-not-getting-logged-in-user-data
            $credential = [
                'USUARIO_login' => $usuario, 'password' => ($senha)
            ];
            
            $user = new \App\Usuario;
            $user->USUARIO_login = $usuario; $user->password = Hash::make($senha);;
            
            if(Auth::attempt($credential)){
                return redirect()->intended('admin');
            }else{
                $resp = '<div class="alert alert-info">Usuário inválido</div>';
            }
            
        }   
        return view('login.index', ['resp' => $resp]);
    }
    
}
