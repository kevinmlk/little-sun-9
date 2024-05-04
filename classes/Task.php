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
      
    }

    // Task method to get all task types
    public static function getAllTaskTypes() {

    }
  }