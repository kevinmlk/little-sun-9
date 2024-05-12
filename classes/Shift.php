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

  /**
   * Check if the employee has approved PTO during the shift time
   */
  private function hasApprovedPTO($employeeId, $startTime, $endTime) {
    $conn = Db::getConnection();
    $statement = $conn->prepare('
      SELECT COUNT(*) 
      FROM timeoffrequests 
      WHERE UserId = :employeeId 
        AND Approved = 1 
        AND (
          (StartDate <= :startTime AND EndDate >= :endTime) OR
          (StartDate <= :startTime AND EndDate >= :startTime) OR
          (StartDate <= :endTime AND EndDate >= :endTime)
        )
    ');
    $statement->bindValue(':employeeId', $employeeId);
    $statement->bindValue(':startTime', $startTime);
    $statement->bindValue(':endTime', $endTime);
    $statement->execute();
    return $statement->fetchColumn() > 0;
  }

  public function addShift() {
    $employeeId = $this->getEmployee();
    $startTime = $this->getStartTime();
    $endTime = $this->getEndTime();

    // Check if the employee has approved PTO
    if ($this->hasApprovedPTO($employeeId, $startTime, $endTime)) {
      return false; // or throw an exception or return a specific error message
    }

    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();
    // Prepare query statement
    $statement = $conn->prepare('
      INSERT INTO shifts (LocationId, EmployeeId, TaskId, StartTime, EndTime) 
      VALUES (:locationid, :employeeid, :taskid, :starttime, :endtime)
    ');

    // Bind query values
    $statement->bindValue(':locationid', $this->getLocation());
    $statement->bindValue(':employeeid', $employeeId);
    $statement->bindValue(':taskid', $this->getTask());
    $statement->bindValue(':starttime', $startTime);
    $statement->bindValue(':endtime', $endTime);

    // Execute the query
    $result = $statement->execute();
    return $result;
  }

  public static function getAllShifts() {
    $conn = Db::getConnection();
    $statement = $conn->prepare('
      SELECT Hubname, Hublocation, Firstname, Lastname, Taskname, StartTime, EndTime 
      FROM shifts 
      INNER JOIN tasks ON shifts.TaskId = tasks.Id 
      INNER JOIN locations ON shifts.LocationId = locations.Id 
      INNER JOIN users ON shifts.EmployeeId = users.Id
    ');
    $statement->execute();
    $shifts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $shifts;
  }

  public static function getUserShifts($userId) {
    $conn = Db::getConnection();
    $statement = $conn->prepare('
      SELECT Taskname, StartTime, EndTime 
      FROM shifts 
      INNER JOIN tasks ON shifts.TaskId = tasks.Id 
      WHERE EmployeeId = :employeeId
    ');
    $statement->bindValue(':employeeId', $userId);
    $statement->execute();
    $shifts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $shifts;
  }
}