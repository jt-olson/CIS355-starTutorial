<?php
require 'database.php';
class FileUpload
{
  private static $pdo;
  private static $sql;
  private static $q;
  public function upload($content, $fileSize, $username)
  {
    self::$pdo = Database::connect();
    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$sql = "UPDATE users SET picture = ?, picSize = ? WHERE username = ?";
    self::$q = self::$pdo->prepare(self::$sql);
    self::$q->execute(array($content, $fileSize, $username));
    Database::disconnect();
  }
}
?>