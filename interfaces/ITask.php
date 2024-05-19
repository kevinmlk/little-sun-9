<?php
  interface ITask {
    // Method to create new task types (admin only)
    public function createTaskType();

    // Method to delete task types
    public function deleteTaskType();

    // Function to get all task types
    public static function getAllTaskTypes();
  }