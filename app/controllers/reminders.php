<?php

class Reminders extends Controller {

    public function index() {
        $R = $this->model('Reminder');
        $list_of_reminders = $R->get_all_reminders();
        $this->view('reminders/index', ['reminders' => $list_of_reminders]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'];

            $R = $this->model('Reminder');
            $R->create_reminder($subject);

            header('Location: /reminders');
            exit;
        }

        $this->view('reminders/create');
    }


    public function update($id) {
        $R = $this->model('Reminder');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'];
            $R->update_reminder($id, $subject);
            header('Location: /reminders');
            exit;
        }

        $reminder = $R->get_reminder_by_id($id);
        $this->view('reminders/update', ['reminder' => $reminder]);
    }

    public function delete($id) {
        $R = $this->model('Reminder');
        $R->delete_reminder($id);
        header('Location: /reminders');
        exit;
    }
}