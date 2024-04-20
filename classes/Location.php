<?php
// Include ILocation interface
include_once(__DIR__ . '/../interfaces/ILocation.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class Location implements ILocation {
  private $hubName;
  private $hubLocation;

  /**
   * Get the value of hubName
   */
  public function getHubName()
  {
    return $this->hubName;
  }

  /**
   * Set the value of hubName
   */
  public function setHubName($hubName): self
  {
    $this->hubName = $hubName;

    return $this;
  }

  /**
   * Get the value of hubLocation
   */
  public function getHubLocation()
  {
    return $this->hubLocation;
  }

  /**
   * Set the value of hubLocation
   */
  public function setHubLocation($hubLocation): self
  {
    $this->hubLocation = $hubLocation;

    return $this;
  }

  public function addHubLocation() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('INSERT INTO locations (Hubname, Hublocation) VALUES(:hubname, :hublocation);');

    $hubName = $this->getHubName();
    $hubLocation = $this->getHubLocation();

    $statement->bindValue(':hubname', $hubName);
    $statement->bindValue(':hublocation', $hubLocation);

    $result = $statement->execute();

    return $result;
  }

  public function editHubLocation() {
    // Make a Db connection
    $conn = Db::getConnection();
  }

  public function removeHubLocation() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('DELETE FROM locations WHERE Hubname = :hubname');

    $hubName = $this->getHubName();

    $statement->bindValue(':hubname', $hubName);

    $result = $statement->execute();

    return $result;
  }

  public static function getAllHubs() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT * FROM locations;');
    $statement->execute();
    $locations = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $locations;
  }
}