<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

$dbManager = new \models\DatabaseManager();
$result = $dbManager->getInvites();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/template.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Registration</a></li>
                <li><a href="users.php">Members</a></li>
                <li class="active"><a href="invites.php">Invites</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="autorization">


        <div class="panel panel-primary" id="invites">
            <div class="panel-heading">
                <h3 class="panel-title">Инвайты</h3>
            </div>
            <div class="panel-body">

                <table class="table">
                    <thead><td>Инвайт</td><td>Статус</td></thead>
                    <?php
                    foreach($result as $key => $val){
                        $status = $val['status'] === '1' ? "Занят" : "Свободен";
                        echo "<tr><td>{$val['invite']}</td><td>{$status}</td></tr>";
                    }
                    ?>
                </table>

            </div>

        </div>
    </div>

</div> <!-- container end -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="assets/sendFormViaAjax.js"></script>
</body>
</html>
