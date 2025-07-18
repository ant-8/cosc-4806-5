<?php

class Reminder {

    public function __construct() {
    }

    public function get_all_reminders() {
        $db = db_connect();
        $statement = $db->prepare("select * from reminders;");
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function get_reminder_by_id($id) {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM reminders WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    public function update_reminder($id, $subject) {
        $db = db_connect();
        $statement = $db->prepare("UPDATE reminders SET subject = ? WHERE id = ?");
        return $statement->execute([$subject, $id]);
    }

    public function create_reminder($subject, $user_id) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO reminders (subject, user_id) VALUES (?, ?)");
        return $statement->execute([$subject, $user_id]);
    }

    public function delete_reminder($id) {
        $db = db_connect();
        $statement = $db->prepare("DELETE FROM reminders WHERE id = ?");
        return $statement->execute([$id]);
    }
}
?>
