<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Auth;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{   
            
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
            try{
                \Mail::send("msgerro",
                    array('erro' => $e->getMessage()),
                    //function($message) use (){
                    function($message){
                    $message->from("contato.eureclamo@gmail.com");
                    $message->to("marques.coti@gmail.com");
                    $message->subject("Erro -- Eu Reclamo");
                });
            } catch (Exception $ex) {

            }
            if(Auth::check()){
                echo $e->getMessage();
            return response()->view('admin.sistema.index', array('resp' => '<div class="alert alert-danger">'
                . 'Usuário sem acesso!</div>'), 404);
            }else{
                return response()->view('login.index', array('resp' => '<div class="alert alert-danger">'
                . 'Usuário sem acesso!</div>'), 404);
            }
		//return parent::render($request, $e);
	}

}
