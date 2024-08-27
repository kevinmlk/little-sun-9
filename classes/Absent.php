<?php

// Include IUser interface
include_once(__DIR__ . '/../interfaces/IAbsent.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class Absent implements IAbsent {

  // Absent properties
  private $id;
  private $type;
  private $shift;

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
   * Get the value of shift
   */
  public function getShift()
  {
    return $this->shift;
  }

  /**
   * Set the value of shift
   */
  public function setShift($shift): self
  {
    $this->shift = $shift;

    return $this;
  }

  // Methods
  public function addAbsent() {
    // Make db connection
    $conn = Db::getConnection();

    // Prepare query
    $statement = $conn->prepare("INSERT INTO absents (Type, ShiftId) VALUES (:type, :shift)");

    // Bind query values
    $statement->bindValue(':type', $this->getType());
    $statement->bindValue(':shift', $this->getShift());

    // Execute query
    $result = $statement->execute();
    return $result;
  }

  public static function getAllAbsents() {
    // Make db connection
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare("SELECT * FROM absents INNER JOIN shifts ON absents.ShiftId = shifts.Id INNER JOIN users ON shifts.EmployeeId = users.Id;");

    // Execute query
    $statement->execute();

    $absents = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $absents;
  }
}