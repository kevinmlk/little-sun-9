<?php

// Include IUser interface
include_once(__DIR__ . '/../interfaces/IShift.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class Shift implements IShift {

  // Shifts properties
  private $startTime;
  private $endTime;
  private $employee;
  private $task;
  private $location;

  /**
   * Get the value of startTime
   */
  public function getStartTime()
  {
    return $this->startTime;
  }

  /**
   * Set the value of startTime
   */
  public function setStartTime($startTime): self
  {
    $this->startTime = $startTime;

    return $this;
  }

  /**
   * Get the value of endTime
   */
  public function getEndTime()
  {
    return $this->endTime;
  }

  /**
   * Set the value of endTime
   */
  public function setEndTime($endTime): self
  {
    $this->endTime = $endTime;

    return $this;
  }

  /**
   * Get the value of employee
   */
  public function getEmployee()
  {
    return $this->employee;
  }

  /**
   * Set the value of employee
   */
  public function setEmployee($employee): self
  {
    $this->employee = $employee;

    return $this;
  }

  /**
   * Get the value of task
   */
  public function getTask()
  {
    return $this->task;
  }

  /**
   * Set the value of task
   */
  public function setTask($task): self
  {
    $this->task = $task;

    return $this;
  }

  /**
   * Get the value of location
   */
  public function getLocation()
  {
    return $this->location;
  }

  /**
   * Set the value of location
   */
  public function setLocation($location): self
  {
    $this->location = $location;

    return $this;
  }

  public function addShift() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();
    // Prepare query statement
    $statement = $conn->prepare('INSERT INTO shifts (LocationId, EmployeeId, TaskId, StartTime, EndTime) VALUES (:locationid, :employeeid, :taskid, :starttime, :endtime);');

    // Bind query values
    $statement->bindValue(':locationid', $this->getLocation());
    $statement->bindValue(':employeeid', $this->getEmployee());
    $statement->bindValue(':taskid', $this->getTask());
    $statement->bindValue(':starttime', $this->getStartTime());
    $statement->bindValue(':endtime', $this->getEndTime());

    // Execute the query
    $result = $statement->execute();
    return $result;
  }

  public static function getAllShifts() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    // $statement = $conn->prepare('SELECT Taskname, Firstname, Lastname, Hubname, Hublocation FROM shifts INNER JOIN users ON shifts.EmployeeId = users.Id INNER JOIN tasks ON shifts.TaskId = tasks.Id INNER JOIN locations ON shifts.LocationId = locations.Id;');
    $statement = $conn->prepare('SELECT Hubname, Hublocation, Firstname, Lastname, Taskname, StartTime, EndTime FROM shifts INNER JOIN tasks ON shifts.TaskId = tasks.Id INNER JOIN locations ON shifts.LocationId = locations.Id INNER JOIN users ON shifts.EmployeeId = users.Id;');
    $statement->execute();
    $shifts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $shifts;
  }

  public static function getUserShifts($userId) {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT Taskname, StartTime, EndTime FROM shifts INNER JOIN tasks ON shifts.TaskId = tasks.Id WHERE EmployeeId = :employeeId;');
    $statement->bindValue(':employeeId', $userId);
    $statement->execute();
    $shifts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $shifts;
  }
}