<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class SistemaController extends Controller
{
    public function index(){
        $data = array();
        
        // create a log channel
        //$log = new Logger('name');
        //$log->pushHandler(new StreamHandler('teste.log', Logger::WARNING));

        // add records to the log
        //$log->warning('Foo');
        //$log->error('Bar');
        try{
            /*\Mail::send("email",
                array('seguradora' => 'Bradesco Seguros'),
                //function($message) use (){
                function($message){
                $message->from("contato.eureclamo@gmail.com");
                $message->to("marques.coti@gmail.com");
                $message->subject("Contato Eu Reclamo");
            });*/
            $headers = "MIME-Version: 1.1\r\n";
			$headers .= "Content-type: text/plain; charset=UTF-8\r\n";
			$headers .= "From: marques.coti@gmail.com\r\n"; // remetente
			$headers .= "Return-Path: marques.coti@gmail.com\r\n"; // return-path
			$envio = mail("marques.coti@gmail.com", "Assunto", "Texto", $headers);
        }  catch (\Exception $e){
            echo "ERRO" . $e->getMessage();
        }
        
        return view('admin.sistema.index', $data);
    }
    
    public function sair(){
        Auth::logout();
        
        return redirect()->intended('login');
        
    }
}
