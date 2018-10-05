<?php
    require './app/init.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PageTitle</title>
        <?php
            Asset::generateViewportMeta();
            Asset::loadStyles(['general', 'forms']);
        ?>
    </head>
    <body>
        <div class="form-wrapper">
            
        </div>
    </body>
</html>