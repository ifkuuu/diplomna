<?php
session_start();

spl_autoload_register(function($class) {
  $class = str_replace("\\", "/", $class);
  $class = $class . '.php';

  require_once $class;
});

$db = new PDO("mysql:host=" . \Config\DbConfig::DB_HOST . ";dbname=" . \Config\DbConfig::DB_NAME . ";charset=utf8", \Config\DbConfig::DB_USER, \Config\DbConfig::DB_PASS);
$app = new \Core\Application();
$validatorService = new \Service\Validator\ValidatorService();
$encryptionService = new \Service\Encryption\BCryptEncryptionService();

$queryString = $_SERVER['QUERY_STRING'];
if (isset($_GET['page'])) {
    $queryString = preg_replace("/page=-?[0-9]+&?/", '', $queryString);
}
