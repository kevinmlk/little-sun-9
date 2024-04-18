<?php
// Include IUser interface
include_once(__DIR__ . '/../interfaces/IUser.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class User implements IUser {
  private $firstname;
  private $lastname;
  private $email;
  private $password;

  /**
   * Get the value of firstname
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   */
  public function setFirstname($firstname): self
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get the value of lastname
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   */
  public function setLastname($lastname): self
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   */
  public function setEmail($email): self
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   */
  public function setPassword($password): self
  {
    $this->password = $password;

    return $this;
  }

  // Login function for login page
  public function loginUser() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare("SELECT * FROM users WHERE email = ':email';");
    
    $email = $this->getEmail();

    // Bind query values
    $statement->bindValue(':email', $email);

    // Store the results of the query execution
    $user = $statement->execute(PDO::FETCH_ASSOC);

    // Return the the result
    return $user;
  }

  // Create user function for admin
  public function createUser() {
    $conn = Db::getConnection();
  }
}