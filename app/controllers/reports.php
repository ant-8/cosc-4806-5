<?php
class Reports extends Controller {
    public function index() {
        session_start();
        if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'Admin') {
            http_response_code(403);
            echo 'Access denied.';
            exit;
        }

        $reminderModel = $this->model('Reminder');
        $reportModel = $this->model('Report');
        $data = [
            'reminders' => $reminderModel->get_all_reminders(),
            'top_user' => $reportModel->get_user_with_most_reminders(),
            'login_counts' => $reportModel->get_total_logins_by_username()
        ];
        $this->view('reports/index', $data);
    }
}