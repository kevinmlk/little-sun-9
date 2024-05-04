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
  private $newPassword;
  private $profilePicture;
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
   * Get the value of newPassword
   */
  public function getNewPassword()
  {
    return $this->newPassword;
  }

  /**
   * Set the value of newPassword
   */
  public function setNewPassword($newPassword): self
  {
    $this->newPassword = $newPassword;

    return $this;
  }

  /**
   * Get the value of profilePicture
   */
  public function getProfilePicture()
  {
    return $this->profilePicture;
  }

  /**
   * Set the value of profilePicture
   */
  public function setProfilePicture($profilePicture): self
  {
    $this->profilePicture = $profilePicture;

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
    $conn = Db::getConnection();

    // // Prepare query statement
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email;");

    $email = $this->getEmail();

    // Bind query values
    $statement->bindValue(':email', $email);

    // Store the results of the query execution
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if the given pwd from the input matches the pwd from the db
    if (password_verify($this->getPassword(), $user['Password'])) {
      // Store the role of the user in the session
      function roleSetter($r) {
        switch ($r) {
          case 3:
             return 'Manager';
            break;
          case 2:
            return 'Admin';
            break;
          default:
            return 'Employee';
        }
      }
      session_start();
      $_SESSION['role'] = roleSetter($user['RoleId']);
      $_SESSION['name'] = $user['Firstname'];
      $_SESSION['profile-picture'] = $user['ProfilePicture'];
      return true;
    } else {
      return false;
    }
  }

  // Create user function for admin
  public function createUser() {
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('INSERT INTO users (Firstname, Lastname, Email, Password, ProfilePicture, RoleId) VALUES(:firstname, :lastname, :email, :password, :profilepicture, :role);');

    // Plaats de input van de SETTERS in een variabele met GETTERS
    $firstname = $this->getFirstname();
    $lastname = $this->getLastname();
    $email = $this->getEmail();
    $profilePicture = $this->getProfilePicture();

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
    $statement->bindValue(':profilepicture', $profilePicture);
    $statement->bindValue(':role', $role);

    $result = $statement->execute();
    // Return result
    return $result;
  }

  public function editUserPassword() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('UPDATE users SET Password = :newpassword WHERE Firstname = :firstname;');

    $firstname = $this->getFirstname();

    // Hash password with bcrypt
		$options = [
			'cost' => 15,
		];

		$newPassword = password_hash($this->getNewPassword(), PASSWORD_DEFAULT, $options);

    $statement->bindValue(':newpassword', $newPassword);
    $statement->bindValue(':firstname', $firstname);

    $result = $statement->execute();

    return $result;  
  }

  public static function getAllUsers() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT Firstname, Lastname, Email, RoleName FROM users INNER JOIN roles ON users.RoleId = roles.Id;');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }
}