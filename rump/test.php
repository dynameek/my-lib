<?php
    require '../app/init.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PageTitle</title>
        <?php
            Asset::generateViewportMeta();
            Asset::loadStyles(['general', 'forms', 'colors']);
        ?>
    </head>
    <body>
        <div class="form-wrapper">
            <form name="" method="post" action="">
                <?php
                    FormBuilder::createInputElement('text', 'name', 'Please Enter yout name', '', [], 'name');
                    FormBuilder::createInputElement('text', 'username', 'Username', '', [], 'uname');
                    FormBuilder::createSelectElement('country', ['nga' => 'Nigeria', 'usa' => 'United States of America'], [], '');
                    FormBuilder::createTextArea('bio', '', 'Tell about yourself', [], '');
                    FormBuilder::createButton('submit', 'Submit', ['bg-cool-blue', 'input-100', 'no-border'], 'sub')
                ?>  
            </form>
        </div>
    </body>
</html>