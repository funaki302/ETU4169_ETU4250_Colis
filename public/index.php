<?php
  require 'vendor/autoload.php';
  require 'config/config.php';
  require 'routes/web.php';
Flight::start();
  $ds = DIRECTORY_SEPARATOR;
  require('app' . $ds . 'config' . $ds . 'bootstrap.php');