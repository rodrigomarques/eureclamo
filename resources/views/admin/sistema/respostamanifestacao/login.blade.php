<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css"
              href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="col-xs-offset-3 col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>EU RECLAMO - LOGO</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                Usuarios:
                                <input type="text" name="usuario" class="form-control">
                            </div>
                            <div class="form-group">
                                Senha:
                                <input type="password" name="password" class="form-control">
                            </div>
                            <input type="submit" value="LOGAR" class="btn btn-danger">
                            
                        </form>
                    </div>
                </div>
                {!! $resp or '' !!}
            </div>
        </div>
    </body>
</html>
