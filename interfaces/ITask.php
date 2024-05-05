<?php
  interface ITask {
    // Method to create new task types (admin only)
    public function createTaskType();

    // Function to get all task types
    public static function getAllTaskTypes();
  }