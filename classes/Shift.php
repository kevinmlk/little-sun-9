<?php

// Include IUser interface
include_once(__DIR__ . '/../interfaces/IShift.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class Shift implements IShift {

  public static function getAllShifts() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT Taskname, Firstname, Lastname, Hubname, Hublocation FROM shifts INNER JOIN users ON shifts.EmployeeId = users.Id INNER JOIN tasks ON shifts.TaskId = tasks.Id INNER JOIN locations ON shifts.LocationId = locations.Id;');
    $statement->execute();
    $shifts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $shifts;
  }
}