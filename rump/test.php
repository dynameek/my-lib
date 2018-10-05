<?php
    require '../app/init.php';
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
            <form name="" method="post" action="">
                <?php
                    FormBuilder::createInputElement('text', 'name', 'Please Enter yout name', '', [], 'name');
                ?>  
            </form>
        </div>
    </body>
</html>