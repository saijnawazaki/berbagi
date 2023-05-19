<?php
defined('APP_PATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=MAFURA_URL?>mafura.css" rel="stylesheet">
    <title><?=APP_TITLE?></title>
    
    <link rel="apple-touch-icon" sizes="57x57" href="<?=APP_URL?>assets/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=APP_URL?>assets/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=APP_URL?>assets/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=APP_URL?>assets/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=APP_URL?>assets/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=APP_URL?>assets/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=APP_URL?>assets/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=APP_URL?>assets/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=APP_URL?>assets/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=APP_URL?>assets/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=APP_URL?>assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=APP_URL?>assets/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=APP_URL?>assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=APP_URL?>assets/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=APP_URL?>assets/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
  </head>
  <body>
    <header class="nav bg-black color-white">
        <div class="container">
            <div class="row">
                <div class="col-2 col-sm-9">
                    <h1>
                        <img src="<?=APP_URL?>assets/berbagi.png" style="width: 34px;">
                    </h1>
                </div>
                <div class="col-sm-3 col-10">
                    <?php
                        if(isset($ses['user_id']))
                        {
                        ?>
                            <div class="bg-light color-black p-1 text-right">
                                <?=$ses['display_name'].' (@'.$ses['username'].')'?>
                                <div>
                                    <a href="<?=APP_URL.'?page=logout'?>">Logout</a>
                                </div>
                            </div>
                        <?php
                        }
                    ?>
                    
                </div>
            </div> 
        </div>
    </header>
    <?php
        if(isset($_SESSION['mess']) && $_SESSION['mess'] != '')
        {
            ?>
            <div class="bg-warning color-black">
                <?=$_SESSION['mess']?>
            </div>
            <?php
            $_SESSION['mess'] = '';
        }
        require 'page.php';    
    ?>
    <footer>
        <div class="container">
            <hr> 
            <small>&copy; 2022 - 2023 saijnawazaki / Mana Studio. Version: <?=APP_VERSION?> / Designed with Mafura</small>
        </div> 
    </footer>
    <div role="alert" id="alert_mess" class="position-fixed top-0 left-0 width-fluid height-vh" style="display: none;">
      <div class="position-relative width-fluid height-vh d-flex justify-content-center">
        <div class="bg-dark position-absolute width-fluid height-vh top-0 left-0 opacity-3" data-toggle="hide" aria-controls="alert_open_dismiss"></div>
        <div class="bg-light bc-muted color-dark br-2 p-3 position-absolute mt-3 ms-auto me-auto mb-auto" style="width: 500px;">
          <div id="alert_mess_content"></div>
          <div class="text-right">
            <a href="javascript:void(0)" class="me-2 link-no-underline" onclick="document.getElementById('alert_mess').style.display = 'none';">
              OK
            </a>
          </div>
        </div>
      </div>
    </div>

    <script src="<?=MAFURA_URL?>mafura.js"></script>
    <script>
        /*https://stackoverflow.com/a/149099*/
        function formatNumber(number, decPlaces, decSep, thouSep) {
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSep = typeof decSep === "undefined" ? "." : decSep;
            thouSep = typeof thouSep === "undefined" ? "," : thouSep;
            var sign = number < 0 ? "-" : "";
            var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
            var j = (j = i.length) > 3 ? j % 3 : 0;

            return sign +
                (j ? i.substr(0, j) + thouSep : "") +
                i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
                (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
        }
        
    </script>
  </body>
</html>