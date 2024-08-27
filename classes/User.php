<?php
// Include IUser interface
include_once(__DIR__ . '/../interfaces/IUser.php');
// Include Db file
include_once(__DIR__ . '/Db.php');

class User implements IUser {

  // Properties
  private $id;
  private $firstname;
  private $lastname;
  private $email;
  private $password;
  private $newPassword;
  private $profilePicture;
  private $role;
  private $task;

  private $newTask;
  private $location;

  

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
   * Get the value of newTask
   */
  public function getNewTask()
  {
    return $this->newTask;
  }

  /**
   * Set the value of newTask
   */
  public function setNewTask($newTask): self
  {
    $this->newTask = $newTask;

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
      $_SESSION['id'] = $user['Id'];
      $_SESSION['role'] = roleSetter($user['RoleId']);
      $_SESSION['name'] = $user['Firstname'];
      $_SESSION['profilePicture'] = $user['ProfilePicture'];
      $_SESSION['hubId'] = $user['LocationId'];
      $_SESSION['taskId'] = $user['TaskId'];
      return true;
    } else {
      return false;
    }
  }

  public function createUser() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('INSERT INTO users (Firstname, Lastname, Email, Password, ProfilePicture, RoleId, TaskId, LocationId) VALUES(:firstname, :lastname, :email, :password, :profilepicture, :roleid, :taskid, :locationid);');

    // Bind query values
    $statement->bindValue(':firstname', $this->getFirstname());
    $statement->bindValue(':lastname', $this->getLastname());
    $statement->bindValue(':email', $this->getEmail());

    // Hash password with bcrypt
    $options = [
      'cost' => 15,
    ];

    $password = password_hash($this->getPassword(), PASSWORD_DEFAULT, $options);

    $statement->bindValue(':password', $password);
    $statement->bindValue(':profilepicture', $this->getProfilePicture());
    $statement->bindValue(':roleid', $this->getRole());
    $statement->bindValue(':taskid', $this->getTask());
    $statement->bindValue(':locationid', $this->getLocation());

    // Store the results of the query execution
    $result = $statement->execute();
    return $result;
  }

  public function assignTask() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('UPDATE users SET TaskId = :taskid WHERE Id = :id;');

    $statement->bindValue(':taskid', $this->getTask());
    $statement->bindValue(':id', $this->getId());

    // Store the results of the query execution
    $result = $statement->execute();
    return $result;
  }

  public function deleteAllHubUsers() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('DELETE FROM users WHERE LocationId = :locationid;');

    $locationId = $this->getLocation();

    $statement->bindValue(':locationid', $locationId);

    // Store the results of the query execution
    $result = $statement->execute();
    return $result;
  }

  public function editTaskType() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('UPDATE users SET TaskId = :newtaskid WHERE TaskId = :oldtaskid;');

    $statement->bindValue(':newtaskid', $this->getNewTask());
    $statement->bindValue(':oldtaskid', $this->getTask());

    // Store the results of the query execution
    $result = $statement->execute();
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

  public function resetPassword() {
    // Make a Db connection
    $conn = Db::getConnection();

    // Prepare query statement
    $statement = $conn->prepare('UPDATE users SET Password = :newpassword WHERE Id = :id;');

    $id = $this->getId();

    // Hash password with bcrypt
    $options = [
      'cost' => 15,
    ];

    $newPassword = password_hash($this->getNewPassword(), PASSWORD_DEFAULT, $options);

    $statement->bindValue(':newpassword', $newPassword);
    $statement->bindValue(':id', $id);

    $result = $statement->execute();

    return $result;
  }

  public static function getAllUsers() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT users.Id, Firstname, Lastname, Email, LocationId, RoleName, Taskname, Hubname, Hublocation FROM users INNER JOIN roles ON users.RoleId = roles.Id INNER JOIN tasks ON users.TaskId = tasks.Id INNER JOIN locations ON users.LocationId = locations.Id;');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }

  public static function getLastAddedUser() {
    // Conn met db via rechtstreekse roeping
    $conn = Db::getConnection();

    // Insert query
    $statement = $conn->prepare('SELECT * FROM users ORDER BY Id DESC LIMIT 1;');
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
  }
}