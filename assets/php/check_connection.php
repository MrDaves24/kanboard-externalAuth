<?php
  // Script will return JSON data
  header('Content-Type: application/json; charset=utf-8');

  require_once(__DIR__."/../../../../vendor/autoload.php");
  require_once("/home/www/cool_func.php");
  show_errors();

  use PicoDb\Database;

  // Getting all the needed
  $type = post_or_die("type");
  $host = post_or_die("host");
  $db = post_or_die("db");
  $prefix = post_or_die("prefix", true, "");
  $user = post_or_die("user");
  $pwd = post_or_die("pwd");
  $port = post_or_die("port", true, 3306);

  // nop("Debugging POST values", ["type" => $type,"host" => $host,"db" => $db,"prefix" => $prefix,"user" => $user,"pwd" => $pwd,"port" => $port,]);

  try {
    switch($type) {
      case "mysql": {
        $db = new Database([
          'driver' => 'mysql',
          'hostname' => $host,
          'username' => $user,
          'password' => $pwd,
          'database' => $db,
          'port' => $port,
        ]);
      } break;
      case "postgres": {
        $db = new Database([
          'driver' => 'postgres',
          'hostname' => $host,
          'username' => $user,
          'password' => $pwd,
          'database' => $db,
          'port' => $port,
        ]);
      } break;

      default:
        nop("Unknown DB type", $type);
    }
  } catch(Exception $e) {
    nop("Can't open connection !", $e);
  }

  try {
    $db->execute("SELECT TRUE;");
  } catch (\Exception $e) {
    nop("Can't execute basic request", $e);
  }

  // If everything went well, sending a success status
  die(json_encode(["status" => "OK", "result" => "OK"]));

  // Working functions
  function post_or_die($name, $null_it = false, $default_value = null) {
    if ($null_it && empty($_POST[$name])) {
      return $default_value;
    } else if (isset($_POST[$name])) {
      return $_POST[$name];
    } else {
      nop("Missing POST key !", $name);
    }
  }

  function nop($msg, $err2 = false) {
    if ($err2 !== false) {
      die(json_encode(["status" => "error", "msg" => $msg, "err2" => $err2]));
    } else {
      die(json_encode(["status" => "error", "msg" => $msg]));
    }
  }
