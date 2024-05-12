<?php

include_once(__DIR__ . '/../interfaces/IDb.php');
include_once(__DIR__ . '/Db.php');

class PTO {

    private $userId;
    private $type;
    private $startDate;
    private $endDate;
    private $approved;

    public function __construct($userId, $type, $startDate, $endDate, $approved = 0) {
        $this->userId = $userId;
        $this->type = $type;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->approved = $approved;
    }

    public function create() {
        $conn = Db::getConnection();
        $sql = "INSERT INTO timeoffrequests (UserId, Type, StartDate, EndDate, Approved) VALUES (:userId, :type, :startDate, :endDate, :approved)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':userId', $this->userId);
        $stmt->bindValue(':type', $this->type);
        $stmt->bindValue(':startDate', $this->startDate);
        $stmt->bindValue(':endDate', $this->endDate);
        $stmt->bindValue(':approved', $this->approved);
        return $stmt->execute();
    }

    public static function getAll() {
        $conn = Db::getConnection();
        $sql = "SELECT t.Id, t.UserId, t.Type, t.StartDate, t.EndDate, t.Approved, u.Firstname, u.Lastname FROM timeoffrequests t JOIN users u ON t.UserId = u.Id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateApproval($id, $approved) {
        $conn = Db::getConnection();
        $sql = "UPDATE timeoffrequests SET Approved = :approved WHERE Id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':approved', $approved, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function handleSubmission() {
        session_start(); // Ensure session is started at the method beginning
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['submit_timeoff'])) {
                if (!isset($_SESSION['id'])) {
                    return 'Session ID not set';
                }
                $userId = $_SESSION['id'];
                $type = $_POST['type'];
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];

                $pto = new PTO($userId, $type, $startDate, $endDate);
                return $pto->create() ? 'PTO request submitted successfully.' : 'Failed to submit PTO request.';
            }

            if (isset($_POST['approve'])) {
                $requestId = $_POST['request_id'];
                $approved = $_POST['approved'];

                return PTO::updateApproval($requestId, $approved) ? ($approved ? "PTO request approved." : "PTO request revoked.") : "Failed to update PTO request.";
            }
        }
        return '';
    }
}