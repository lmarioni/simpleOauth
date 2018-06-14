<!DOCTYPE html>
<html>
<head>
  <!-- Global Site Tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107773288-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-107773288-1');
  </script>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
  <meta name="description" content="">
  <title>simpleOAuth de Mercado Libre</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic&amp;subset=latin">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
  <link rel="stylesheet" href="../assets/bootstrap-material-design-font/css/material.css">
  <link rel="stylesheet" href="../assets/tether/tether.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/animate.css/animate.min.css">
  <link rel="stylesheet" href="../assets/theme/css/style.css">
  <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">
    <meta property="og:description" content="simpleoauth"/>
  <meta property="og:image" content="https://simpleoauth.com/assets/images/mbr-2000x1328.jpg"/>
  <meta property="og:site_name" content="simpleoauth.com" />
  <meta property="og:title" content="Un token para todas tus llamadas" />
  <meta property="og:url" content="http://simpleoauth.com" />
  
  
</head>
<body>
<section class="mbr-section mbr-section-hero mbr-section-full mbr-parallax-background" id="header1-1" style="background-image: url(../assets/images/mbr-2000x1328.jpg);">

    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(0, 0, 0);"></div>

    <div class="mbr-table-cell">

        <div class="container">
            <div class="row">
                <div class="mbr-section col-md-10 col-md-offset-1 text-xs-center">
                  <form action="/api/meli/submit/" method="post">
                    <h1 class="mbr-section-title display-1" style="font-size: 4.39rem;">simpleOAuth</h1>
                    <p class="mbr-section-lead lead">Autentícate en Mercado Libre, autoriza la aplicación y obtén un <strong>token</strong> único con el que podrás obtener el <strong>access_token</strong> siempre renovado para tu solución de integración con la API de Mercado Libre.</p>
                    <div class="mbr-section-btn"><input type="submit" value="LOGIN" class="btn btn-lg btn-danger"> </div>
                    </br>
                    <a id="show_app" href="javascript:showApp();" style="color:white">¿Quieres usar el app_id y secret_key de tu propia aplicación de Mercado Libre?</a>
                    <div style="display:none;" id="app_section">
                    <p style="color:white;">Si ya tienes una aplicación propia de Mercado Libre, pega aquí el app_id y secret_key:</p>
                    <p style="color:white" id="application_data">
                      <input type="text" name="app_id" placeholder="Application ID">
                      <input type="password" name="secret_key" placeholder="Secret Key">
                    </p>
                    <p style="color:white">Recuerda que deberás poner "<b>https://simpleoauth.com/api/meli/login/</b>" en redirect URI.<br/>(Para ver y editar tus aplicaciones haz clic <a target="_blank" href="http://applications.mercadolibre.com/">aquí</a>)</p>
                    </div>
                  </form>
                </div>

            </div>
        </div>
    </div>

    

</section>
  <script>
    function showApp(){
      $('#show_app').hide();
      $('#app_section').show();
    }

  </script>
  <script src="../assets/web/assets/jquery/jquery.min.js"></script>
  <script src="../assets/tether/tether.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/smooth-scroll/SmoothScroll.js"></script>
  <script src="../assets/jarallax/jarallax.js"></script>
  <script src="../assets/viewportChecker/jquery.viewportchecker.js"></script>
  <script src="../assets/theme/js/script.js"></script>
  
  
  <input name="animation" type="hidden">
  </body>
</html>