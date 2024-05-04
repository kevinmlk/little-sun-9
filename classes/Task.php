<?php


class Task {
    private $dbconnection;

    public function __construct(mysqli $db) {
        $this->dbconnection = $db;
    }

    public function getTaskByUserId(int $userId): array {
        $statement = $this->dbconnection->prepare('SELECT TaskID, TaskName FROM Task WHERE user_id = ?');
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $tasks;
    }
}


    




