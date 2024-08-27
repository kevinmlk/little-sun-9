<?php

  // Include ITask interface
  include_once(__DIR__ . '/../interfaces/ITask.php');
  // Include Db file
  include_once(__DIR__ . '/Db.php');

  class Task implements ITask {

    // Task properties
    private $id;
    private $taskName;
    
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

    public function deleteTaskType() {
      // Make db connection
      $conn = Db::getConnection();

      // Prepare query statement
      $statement = $conn->prepare('DELETE FROM tasks WHERE Id = :id;');

      // Bind query values
      $statement->bindValue(':id', $this->getId());

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
  }