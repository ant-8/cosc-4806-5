<?php
class Reports extends Controller {
    public function index() {
        $reminderModel = $this->model('Reminder');
        $data = ['reminders' => $reminderModel->get_all_reminders()];
        $this->view('reports/index', $data);
    }
}