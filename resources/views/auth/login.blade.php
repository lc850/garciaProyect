<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sweetalert.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <style>
    body{
      background-color: #3c8dbc;
    }
    .panel{
      margin-top: 8%;
      padding: 0% 1% 0% 1%;
      border: 1px solid darkblue;
    }
    .top{
      margin-top: 10px;
    }
    .fondo{
      background-color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-body text-center">
            <img src="images/logo3.png" alt="" width="180px">
          </div>
          <div class="panel-footer fondo">
            <form class="top" action="{{ route('login') }}" method="post" onsubmit="return recaptcha()">
              {{ csrf_field() }}
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <div class="input-group">
                <span class="input-group-addon input-lg fondo" id="basic-addon1">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </span>
                <input type="text" class="form-control input-lg" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo electrónico">
              </div>
              @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
              </div>
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                <span class="input-group-addon input-lg fondo" id="basic-addon1">
                  <i class="fa fa-lock" aria-hidden="true"></i>
                </span>
                <input id="password" type="password" name="password" class="form-control input-lg" placeholder="Contraseña" required>
              </div>
              @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
              </div>
              <div class="form-group">    
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Iniciar Sesión</button>
              </div>
            </form>
            <div class="panel-footer fondo">
              <div class="form-group">
                <a class="pull-right" href="{{ route('password.request') }}">¿Olvidaste la contraseña?</a>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordar
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  /*function recaptcha(){
      if (grecaptcha.getResponse() == ""){
          swal({   title: "reCAPTCHA!",   text: "Porfavor verifica el reCAPTCHA...",   imageUrl: "images/recaptcha.gif", imageSize: '250x250' });
          return false;
    }else 
          return true;
      }*/
</script>
</body>
</html>