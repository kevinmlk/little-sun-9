<?php

  // Include ITask interface
  include_once(__DIR__ . '/../interfaces/ITask.php');
  // Include Db file
  include_once(__DIR__ . '/Db.php');

  class Task implements ITask {

    // Task properties
    private $taskName;
    
    /**
     * Get the value of taskName
     */
    public function getTaskName()
    {
        return $this->taskName;
    }

    /**
     * Set the value of taskName
     */
    public function setTaskName($taskName): self
    {
        $this->taskName = $taskName;

        return $this;
    }

    // Task methods

    // Task method to create new task types (admin only)
    public function createTaskType() {
      // Make db connection
      $conn = Db::getConnection();

      // Prepare query statement
      $statement = $conn->prepare('INSERT INTO tasks (Taskname) VALUES (:taskname);');

      // Bind query values
      $statement->bindValue(':taskname', $this->getTaskName());

      // Execute the query
      $result = $statement->execute();
      return $result;
    }

    // Task method to get all task types
    public static function getAllTaskTypes() {
      // Make db connection
      $conn = Db::getConnection();

      // Prepare query statement
      $statement = $conn->prepare('SELECT * FROM tasks;');
      $statement->execute();
      $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $tasks;
    }

    // Method to fetch all tasks assigned to users
    public static function getAllAssignedTasks() {
      // Establish database connection
      $conn = Db::getConnection();

      // Prepare SQL query to fetch all tasks with assigned user details
      $sql = "SELECT t.TaskID, t.TaskName, u.Firstname, u.Lastname, u.Id AS UserID 
              FROM Tasks t 
              JOIN users u ON t.UserID = u.Id;";
      
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      
      // Fetch all tasks
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }