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
  private $role;

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

    /**
   * Get the value of role
   */
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   */
  public function setRole($role): self
  {
    $this->role = $role;

    return $this;
  }

  // Login function for login page
  public function loginUser() {
    // // Make a Db connection
    // $conn = Db::getConnection();

    // // Prepare query statement
    // $statement = $conn->prepare("SELECT * FROM users WHERE email = ':email';");
    $adminEmail = 'jane.doe@admin.zm';

    $email = $this->getEmail();

    if ($email === $adminEmail) {
      return true;
    } else {
      return false;
    }

    // Bind query values
    // $statement->bindValue(':email', $email);

    // Store the results of the query execution
    // $statement->execute();

    // $user = $statement->fetchAll(PDO::FETCH_ASSOC);

  }

  // Create user function for admin
  public function createUser() {
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('INSERT INTO users (Firstname, Lastname, Email, Password, RoleId) VALUES(:firstname, :lastname, :email, :password, :role);');

    // Plaats de input van de SETTERS in een variabele met GETTERS
    $firstname = $this->getFirstname();
    $lastname = $this->getLastname();
    $email = $this->getEmail();

    // Hash password with bcrypt
		$options = [
			'cost' => 15,
		];

		$password = password_hash($this->getPassword(), PASSWORD_DEFAULT, $options);
    
    $selectedRole = $this->getRole();

    function roleSetter($r) {
      switch ($r) {
        case 'Manager':
           return 3;
          break;
        case 'Admin':
          return 2;
          break;
        default:
          return 1;
      }
    }

    $role = roleSetter($selectedRole);
    
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':role', $role);

    $result = $statement->execute();
    // Return result
    return $result;
  }

  public static function getAllUsers() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT * FROM users;');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }
}