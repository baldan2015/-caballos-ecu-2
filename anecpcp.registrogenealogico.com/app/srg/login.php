<? session_start();
include_once("entidad/Constantes.php");
unset($_SESSION[Constantes::K_SESSION_USUARIO]);
unset($_SESSION[Constantes::K_SESSION_EMPRESA]);
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-104927954-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-104927954-3');
  </script>
  <meta charset="utf-8" />
  <title>ANECPCP - REGISTRO GENEALOGICO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src='https://www.google.com/recaptcha/api.js?render=6LcsW1QnAAAAAKqGcFVLrUHq7gPrB9C5LLnDFfuf'> </script>

  <link rel="stylesheet" href="libs/jquery-ui-1.11.4.custom.green/jquery-ui.css">
  <link rel="stylesheet" href="css/login.css">
  <script src="libs/jquery/jquery.js"></script>
  <script src="libs/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
  <script src="script/generales/loading.js"></script>
  <script src="script/Login.js"></script>
  <style>
    .control-text {
      display: block;
      padding: 8px 7px;
      font-size: 14px;
      border: 1px solid #ddd;
      background: #f5f5f5;
      -webkit-box-shadow: inset 0 1px 2px rgb(0 0 0 / 5%);
      -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .05);
      -webkit-box-shadow: inset 0 1px 2px rgb(0 0 0 / 5%);
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
    }
  </style>
</head>

<body>

  <br> <br> <br> <br> <br>

  <div id="wrap-login">
    <div id="box-login" class="ui-state-default ui-widget-content ui-state-default ui-widget-header ui-state-default">
      <center>
        <span class="title_big"><br>
          <div style="width: 100%;">
            <img src="images/logo/logo.jpg" /><br><br>
            ACCESO AL REGISTRO GENEALOGICO - ECUADOR
            <br><img src="images/icono/flag.png" width="40">

          </div>
        </span>
      </center>
      <div id="box-login-top">
        <form>
          <fieldset>
            <input type="text" id="username" placeholder="username" class="form-text">
          </fieldset>

          <fieldset>
            <input type="password" id="password" placeholder="password" class="form-text">
          </fieldset>
         
          <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
          <fieldset class="form-actions">
            <input type="button" name="btmSubmit" id="btmSubmit" value="Enviar">
            <a href="#" alt="#">Cancelar</a>
          </fieldset>

        </form>
      </div>
      <div id="box-login-bottom">
        <div id="footer-login">
          <span id="result">Ingrese usuario y contrase&ntilde;a</span>

        </div>
      </div>

    </div>

  </div>
  </div>
  <div id="wrap-bottom" style="color: #fff;">
    Asociación Nacional de Criadores y Propietarios de Caballos de Paso <br />


  </div>
</body>

</html>