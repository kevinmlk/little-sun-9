<?php
// Include ILocation interface
include_once(__DIR__ . '/../interfaces/ILocation.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class Location implements ILocation {
  private $hubName;
  private $hubLocation;
  private $newHubName;
  private $newHubLocation;

  /**
   * Get the value of newHubName
   */
  public function getNewHubName()
  {
    return $this->newHubName;
  }

  /**
   * Set the value of newHubName
   */
  public function setNewHubName($newHubName): self
  {
    $this->newHubName = $newHubName;

    return $this;
  }

  /**
   * Get the value of newHubLocation
   */
  public function getNewHubLocation()
  {
    return $this->newHubLocation;
  }

  /**
   * Set the value of newHubLocation
   */
  public function setNewHubLocation($newHubLocation): self
  {
    $this->newHubLocation = $newHubLocation;

    return $this;
  }

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

    // Prepare query statement
    $statement = $conn->prepare('UPDATE locations SET Hubname = :newhubname, Hublocation = :newhublocation WHERE Hubname = :oldhubname;');

    $oldHubName = $this->getHubName();
    $newHubName = $this->getNewHubName();
    $newHubLocation = $this->getNewHubLocation();

    $statement->bindValue(':oldhubname', $oldHubName);
    $statement->bindValue(':newhubname', $newHubName);
    $statement->bindValue(':newhublocation', $newHubLocation);

    $result = $statement->execute();

    return $result;    
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