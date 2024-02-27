<?php
// $servidor ="mysql:dbname=".BD.";host=".SERVIDOR;
// try {
//   $pdo = new PDO($servidor,USUARIO,PASSWORD,
//   array(PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES utf8"));
//   echo "<script>alert('Conectado')</script>";
// } catch (PDOException $e) {
//   echo "<script>alert('Conectado')</script>";
// }
class DB
{
  private $host;
  private $db;
  private $user;
  private $password;
  private $charset;

  public function __construct()
  {
    $this->host = 'localhost';
    $this->db   = 'carrito';
    $this->user = 'Alfredo';
    $this->password = 'ISC28Alfred';
    $this->charset = 'utf8mb4';
    date_default_timezone_set("America/Mexico_City");
  }

  public function connect()
  {
    try {

      $conn = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
      ];
      $pdo = new PDO($conn, $this->user, $this->password, $options);
      return $pdo;
    } catch (PDOException $e) {

      echo "Error en la conexión: " . $e->getMessage();

      throw $e;
    }
  }
}
