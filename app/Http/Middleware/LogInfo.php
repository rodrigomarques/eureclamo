<?php namespace App\Http\Middleware;

use Closure;
use Auth;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class LogInfo {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
            $msg = date('Y-m-d H:i:s');
            $url = $request->fullUrl();
            $msg .= $url . "|";
            foreach($request->all() as $name => $value){
                if($name != "_token"){
                    if(is_array($value))
                        $msg .= $name . " = " .implode(" ", $value) . "|";
                    else
                        $msg .= $name . " = " . $value . "|";
                }
            }
            if(Auth::check()){
                $login = Auth::user()->USUARIO_login;
                $msg .= $login . "|";
                $id = Auth::user()->USUARIO_id;
                $msg .= $id . "|";
                $email = Auth::user()->USUARIO_email;
                $msg .= $email . "|";
            }
            
            // create a log channel
            $log = new Logger('backlog');
            $nomelog = date('Ym');
            $log->pushHandler(new StreamHandler('log/backlog_' . $nomelog .'.log', Logger::INFO));

            // add records to the log
            $log->info($msg, array('date' => date('d/m/Y H:i')));
            //$log->error('Bar');
            
            return $next($request);
	}

}
