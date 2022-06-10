<?php
defined('APP_PATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://manastudio.id/repo/public/manastudio/mafura/mafura.css" rel="stylesheet">
    <title><?=APP_TITLE?></title>
  </head>
  <body>
    <header class="nav bg-black color-white">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <h1><?=APP_TITLE?></h1>
                </div>
                <div class="col-3">
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
            <small>2022 saijnawazaki. Version: <?=APP_VERSION?> / Designed with Mafura</small>
        </div> 
    </footer>
  </body>
</html>