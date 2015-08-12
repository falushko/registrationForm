<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

$dbManager = new \models\DatabaseManager();
$result = $dbManager->getCountries();

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
            <li class="active"><a href="#">Registration</a></li>
            <li><a href="#about">Members</a></li>
            <li><a href="#contact">Invites</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    <div class="autorization">


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Регистрация</h3>
                    </div>
                    <div class="panel-body">

                                <form role="form" name="form">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                        <input id="login" name="login" type="text" class="form-control" placeholder="Логин" required autofocus />
                                    </div>
                                    <p class="errorMessage" id="loginError">error</p>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                        <input id="pass" name="pass" type="password" class="form-control" placeholder="Пароль" required />
                                    </div>
                                    <p class="errorMessage" id="passError">error</p>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                        <input id="confirm" name="confirm" type="password" class="form-control" placeholder="Еще раз пароль" required autofocus />
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
                                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Телефон" required />
                                    </div>
                                    <p class="errorMessage" id="phoneError">error</p>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                        <select name="country" class="form-control" id="sel1">
                                            <option value="default" selected>Страна</option>
                                            <?php
                                            foreach ($result as $key => $value) {
                                                echo "<option value='{$value["id_country"]}'>{$value["country_name"]}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                                        <select name="city" class="form-control" id="sel2">
                                            <option value="" disabled selected>Город</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span></span>
                                        <input id="invite" name="invite" type="text" class="form-control" placeholder="Инвйат" required />
                                    </div>
                                    <p class="errorMessage" id="inviteError">error</p>

                                </form>

                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-labeled btn-danger" id="clear">
                            <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Очистить</button>

                        <button type="button" class="btn btn-labeled btn-success" id="send">
                            <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Отправить</button>
                    </div>
                </div>

        <div id="success" class="alert alert-success" role="alert">Спасибо за регистрацию!</div>
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
