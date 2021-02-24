<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - {{config('app.name')}}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    </head>
    <body style="padding-top: 10%; background-color: #F5F8FA;">
        <form class="container" action="./logar" method="POST">
            {{ csrf_field() }}
            
            @if (session('warning'))
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-danger" role="alert">
                            {{ session('warning') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="login" class="form-control" name="login" id="login">
                        @if ($errors->has('login')) 
                            <span class="error invalid-feedback" style="display: inline;">  
                                {{ $errors->first('login') }} 
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" name="password" id="password">
                        @if ($errors->has('password')) 
                            <span class="error invalid-feedback" style="display: inline;"> 
                                {{ $errors->first('password') }} 
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">ENTRAR</button>
                </div>
            </div>
        </form>
    </body>
</html>