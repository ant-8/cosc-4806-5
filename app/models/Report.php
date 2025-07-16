<?php
class Report {
    public function __construct() {
    }

    public function get_user_with_most_reminders() {
        $db = db_connect();
        $sql = "SELECT u.username, COUNT(r.id) AS reminders_count
                FROM users u
                LEFT JOIN reminders r ON r.user_id = u.id
                GROUP BY u.id
                ORDER BY reminders_count DESC
                LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}