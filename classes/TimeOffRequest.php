<?php

// Include IUser interface
include_once(__DIR__ . '/../interfaces/ITimeOffRequest.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class TimeOffRequest implements ITimeOffRequest {
  // Properties
  private $id;
  private $employee;
  private $type;
  private $startDate;
  private $endDate;
  private $status;
  private $reason;

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   */
  public function setId($id): self
  {
    $this->id = $id;

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
   * Get the value of type
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * Set the value of type
   */
  public function setType($type): self
  {
    $this->type = $type;

    return $this;
  }

  /**
   * Get the value of startDate
   */
  public function getStartDate()
  {
    return $this->startDate;
  }

  /**
   * Set the value of startDate
   */
  public function setStartDate($startDate): self
  {
    $this->startDate = $startDate;

    return $this;
  }

  /**
   * Get the value of endDate
   */
  public function getEndDate()
  {
    return $this->endDate;
  }

  /**
   * Set the value of endDate
   */
  public function setEndDate($endDate): self
  {
    $this->endDate = $endDate;

    return $this;
  }

  /**
   * Get the value of status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   */
  public function setStatus($status): self
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the value of reason
   */
  public function getReason()
  {
    return $this->reason;
  }

  /**
   * Set the value of reason
   */
  public function setReason($reason): self
  {
    $this->reason = $reason;

    return $this;
  }

  public function addTimeOffRequest() {

  }

  public function setTimeOffRequestStatus() {

  }

  public static function getAllTimeOffRequests() {
    // Make db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('SELECT timeoffrequests.Id AS TimeOffRequestId, EmployeeId, Type, StartDate, EndDate, Status, Reason, Firstname, Lastname, LocationId, Hubname, Hublocation FROM timeoffrequests INNER JOIN users ON timeoffrequests.EmployeeId = users.Id INNER JOIN locations ON users.LocationId = locations.Id;');

    // Execute statement
    $statement->execute();

    // Get results
    $timeOffRequests = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $timeOffRequests;
  }
}