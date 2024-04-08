<?php

include_once(__DIR__ . '/../interfaces/iDb.php');

// Class that implements the iDb interface
class Db implements iDb {
  private $conn;

  // getConnection function - naming according the interface
  public static function getConnection() {
    // Include db settings
    include_once(__DIR__ . '/../settings/settings.php');

    if (self::$conn === null) {
      self::$conn = new PDO('mysql:host=' . SETTINGS['db']['host'] . ';dbname=' . SETTINGS['db']['db'], SETTINGS['db']['user'], SETTINGS['db']['password']);
      return self::$conn;
    } else {
      return self::$conn;
    }
  }
}