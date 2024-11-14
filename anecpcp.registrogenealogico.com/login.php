<?
unset($_SESSION['xusu']); //session_unregister('xusu');
unset($_SESSION['xid']);
unset($_SESSION['xstatus']);
unset($_SESSION['cc']);
require_once('modules/poe/entidad/Constantes.php');
$usu = $_POST['txtusu'];
$pas = $_POST['txtpwd'];
//$captcha = $_POST["recaptcha"];
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css">
<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>
<!--<link href="styles/login.css" rel="stylesheet" type="text/css">-->

<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet" />
<link href="admin/scripts/alerts/themes/alertify.bootstrap.css" rel="stylesheet" />
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>


<?
if (isset($usu) && isset($pas) /*&& isset($captcha)*/) {
  echo ("<tr><td>");
  require(DIR_VALIDAR2);
  echo ("</td></tr>");
} else {

?>

  <!--
<link href="home/css/heroic-features.css" rel="stylesheet">
<link rel="stylesheet" href="styles/styles.css">
<link href="styles/menu2.css" rel="stylesheet">

<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet"/>
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>


<script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
<link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/> 
 
<link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>
-->

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <script src='https://www.google.com/recaptcha/api.js?render=6LcsW1QnAAAAAKqGcFVLrUHq7gPrB9C5LLnDFfuf'> </script>


  <style type="text/css">
    body {
      background-image: url('images/logo/7742.jpg');
      background-size: 100% 115%;
    }


    .login-block {
      /* background: #dff0d8;   
background: -webkit-linear-gradient(to bottom, #3c763d, #dff0d8);   
background: linear-gradient(to bottom, #3c763d, #dff0d8);  */
      float: left;
      width: 100%;
      padding: 50px 0;
    }

    .banner-sec {
      /*background:url(images/login/slide1.jpg)  no-repeat left bottom;  */

      background-size: cover;
      min-height: 500px;
      border-radius: 0 10px 10px 0;
      padding: 0;

    }

    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 15px 20px 0px rgba(0, 0, 0, 0.1);
    }

    .carousel-inner {
      border-radius: 0 10px 10px 0;
    }

    .carousel-caption {
      text-align: left;
      left: 5%;
    }

    .login-sec {
      padding: 50px 30px;
      position: relative;
    }

    .login-sec .copy-text {
      position: absolute;
      width: 80%;
      bottom: 20px;
      font-size: 13px;
      text-align: center;
    }

    .login-sec .copy-text i {
      color: #FEB58A;
    }

    .login-sec .copy-text a {
      color: #337ab7;
    }

    .login-sec h2 {
      margin-bottom: 30px;
      font-weight: 800;
      font-size: 23px;
      color: #000;
    }

    .login-sec h2:after {
      content: " ";
      width: 100px;
      height: 5px;
      background: #dff0d8;
      display: block;
      margin-top: 20px;
      border-radius: 3px;
      margin-left: auto;
      margin-right: auto
    }

    .btn-login {
      background: #3c763d;
      color: #fff;
      font-weight: 600;
    }

    .banner-text {
      width: 70%;
      position: absolute;
      bottom: 40px;
      padding-left: 20px;
    }

    .banner-text h2 {
      color: #fff;
      font-weight: 600;
    }

    .banner-text h2:after {
      content: " ";
      width: 100px;
      height: 5px;
      background: #FFF;
      display: block;
      margin-top: 20px;
      border-radius: 3px;
    }

    .banner-text p {
      color: #fff;
    }

    .topPaginaSlide {
      margin-top: -15px !important;
      background: #dff0d8 !important;
    }
  </style>
  </head>

  <body>
    <nav class="navbar navbar-dark bg-dark" style="background:#101010!important; height:52px!important;">
      <div class="contasiner-fluid">
        <div class="navbar-header" style=' background: #459e00 !important;width: 259px!important;height:52px!important; margin-left: -17px;margin-top:-8px;'>
          <img src='img/logo2.jpg' heigth=25 style="margin-top:1px; " />
        </div>
      </div><!-- /.container-fluid -->
    </nav>

    <section class="login-block">
      <div class="container">
        <div class="row">
          <div class="col-md-4 login-sec">
            <h2 class="text-center">
              <img src="img/99b_usrcheck.png" style="margin-top:-10px;" width="30">&nbsp;ACCESO SOCIOS
              <br>
              <!--	<img src="img/99b_usrcheck.png" width="30"> 
		    	<img src='images/login/anecpcp.jpg'   style="width: 100%;margin-top: -15px; margin-left: -17px;" /></a>-->
            </h2>
            
              <div class="form-group">
                <label for="exampleInputEmail1" class="text-uppercase">Usuario</label>
                <input type="text" class="form-control" id="txtusu" name='txtusu' placeholder="Ingrese usuario">

              </div>
              <div class="form-group">
                <label for="exampleInputPassword1" class="text-uppercase">Contraseña</label>
                <input type="password" class="form-control" name='txtpwd' id='txtpwd' placeholder="Ingrese Contraseña">
              </div>


              <div class="form-check">
              <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
         
              <button id="btnSubmit" class="btn btn-primary float-right" name='b1' value="Ingresar">Ingresar</button>
              </div>

              <div class="form-group">
                <br><br>
                <? if ($message == "") { ?>

                  <span id="result">Ingrese usuario y contrase&ntilde;a</span>
                <? } else { ?>
                  <span id="result" style="color:red;"><?= $message ?></span>

                <? } ?>
              </div>

              <div style="text-align:center" title="Ecuador">
                <img src="images/icono/Ecuador-Flag.png" style="width: 30px;">
              </div>

            <div class="copy-text">Consulta de Genealogía v2&nbsp;&nbsp;<i class="fa fa-heart"></i><a title="solicitar servicios" href="https://teon.pe/#sect006" style="font-weight: bold;" target="_blank">
                &copy; TEON SOLUTIONS.</a></div>
          </div>
          <div class="col-md-8 banner-sec">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active topPaginaSlide"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1" class="topPaginaSlide"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2" class="topPaginaSlide"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                  <img class="d-block img-fluid" src="images/login/slide1.jpg" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                    <div class="banner-text">
                      <!--   <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
          -->
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block img-fluid" src="images/login/slide2.jpg" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                    <div class="banner-text">
                      <!--       <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
         -->
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block img-fluid" src="images/login/slide3.jpg" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                    <div class="banner-text">
                      <!--    <h2>This is Heaven</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
           -->
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
    </section>



  </body>

  </html>



  <!--
<tr><td colspan=2 valign=top     >
 <br> <br> <br> <br> <br>
 
			<div id="wrap-login"  >
            <div id="box-login" class="ui-state-default ui-widget-content ui-state-default ui-widget-header ui-state-default"><center>
              <span  class="title_big"><br>
              <div style="width: 100%;">
              <img src="images/logo/logo.jpg"/><br><br>
              CONSULTAS EN LINEA DEL REGISTRO GENEALOGICO SS
              <br><img src="images/icono/flag.png" width="40"> 

              </div></span>
              </center>
                <div id="box-login-top">
                <form  name='formlog' action='index.php' method='POST'>
                <fieldset>

                    <input type="text" id="txtusu"  name='txtusu' placeholder="username" class="form-text">
		</fieldset>
                    
		<fieldset>
                    <input type="password" name='txtpwd' id='txtpwd'  placeholder="password" class="form-text">
                </fieldset>
                
                    <fieldset class="form-actions">
                                <input type="submit" name='b1' value="Ingresar"  >
                                <a href="#" alt="#">Cancelar</a>
                        </fieldset>
                    
                </form>
           </div>
             <div id="box-login-bottom">
						<div id="footer-login">
						-->
  <? if ($message == "") { ?>

    <!--<span id="result">Ingrese usuario y contrase&ntilde;a</span>-->
  <? } else { ?>
    <!--<span id="result"><?= $message ?></span>-->

  <? } ?>


  <!--		</div>
					</div>
            
            </div>
       
                        </div>
   </div>
        <div id="wrap-bottom" style="color: #fff;">
          
             
            
        </div>


</td></tr>-->

<?

}
?>
<script type="text/javascript">
  $(function() {
    $("#txtusu").focus();
    $("#btnSubmit").click(function() {
      grecaptcha.execute('<? echo ConstantesCatpcha::K_CLAVE_SITIO ?>', {
          action: 'qrsocio'
        })
        .then(function(token) {
          var recaptchaResponse = document.getElementById('recaptchaResponse');
          recaptchaResponse.value = token;
          var datos = {
            recaptcha_response: token,
            txtpwd: $("#txtpwd").val(),
            txtusu: $("#txtusu").val()
          }
          enviar(datos);
          return false;
        });
    });
  })

  function enviar(data) {
    $.ajax({
      data: data,
      url: 'validar.php',
      type: 'post',
      beforeSend: function() {},
      success: function(retorno) {
        var resultado = JSON.parse(retorno);
        if (resultado.result === 1) {
          if (typeof(Storage) !== "undefined") {
            $.ajax({
              data: {
                key: resultado.code
              },
              url: resultado.data,
              type: 'POST',
              success: function(response) {
                console.log(response);
                var retorno = JSON.parse(response);
                if (retorno.result) {
                  localStorage.setItem("Authorization", retorno.token);
                  document.location.replace("socio.php");
                } else {
                  alert(retorno.mensaje);
                  document.location.replace("logoff.php");
                }
              }
            });
          } else {
            alert("LocalStorage no soportado en este navegador.");
            document.location.replace("logoff.php");
          }
        } else {
          alert(resultado.message);
          document.location.replace("logoff.php");
        }
      }
    });
  }
</script>