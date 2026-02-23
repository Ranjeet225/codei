<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    public function get_kpis() {
        // Calculate dynamic values
        $total_balance = 0;
        $total_income = 0;
        $total_expenses = 0;
        $active_users = $this->db->count_all('users');
        
        $this->db->select('SUM(amount) as income');
        $this->db->where('status', 'Completed');
        $inc_query = $this->db->get('transactions')->row();
        if ($inc_query) {
            $total_income = $inc_query->income;
            $total_balance = $total_income; // Simple calculation for balance
        }

        $this->db->select('SUM(amount) as expenses');
        $this->db->where('status', 'Failed'); // For example purposes we treat failed as expense/loss
        $exp_query = $this->db->get('transactions')->row();
        if ($exp_query) {
            $total_expenses = $exp_query->expenses;
            $total_balance -= $total_expenses; 
        }

        // We can just format and keep the UI classes the same as the static version
        return [
            ['title' => 'Total Balance', 'icon' => 'fa-wallet', 'amount' => '$' . number_format($total_balance, 2), 'trend' => 'trend-up', 'trend_icon' => 'fa-arrow-trend-up', 'trend_text' => '+12.5% from last month', 'color_class' => 'icon-blue'],
            ['title' => 'Total Income', 'icon' => 'fa-arrow-down-long', 'amount' => '$' . number_format($total_income, 2), 'trend' => 'trend-up', 'trend_icon' => 'fa-arrow-trend-up', 'trend_text' => '+8.2% from last month', 'color_class' => 'icon-green'],
            ['title' => 'Total Expenses', 'icon' => 'fa-arrow-up-long', 'amount' => '$' . number_format($total_expenses, 2), 'trend' => 'trend-down', 'trend_icon' => 'fa-arrow-trend-down', 'trend_text' => '-2.4% from last month', 'color_class' => 'icon-orange'],
            ['title' => 'Active Users', 'icon' => 'fa-users', 'amount' => number_format($active_users), 'trend' => 'trend-up', 'trend_icon' => 'fa-arrow-trend-up', 'trend_text' => '+4.1% from last month', 'color_class' => 'icon-purple']
        ];
    }

    public function get_recent_transactions() {
        $this->db->select('t.transaction_id as id, t.amount, t.status, t.created_at, u.name, u.avatar, u.initials');
        $this->db->from('transactions t');
        $this->db->join('users u', 't.user_id = u.id');
        $this->db->order_by('t.created_at', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();

        $transactions = [];
        foreach ($query->result_array() as $row) {
            // Apply formatting and CSS classes
            $status_class = 'status-pending';
            if ($row['status'] == 'Completed') $status_class = 'status-completed';
            if ($row['status'] == 'Failed') $status_class = 'status-failed';

            $transactions[] = [
                'id' => $row['id'],
                'avatar' => $row['avatar'],
                'initials' => $row['initials'],
                'name' => $row['name'],
                'date' => date('M d, Y • h:i A', strtotime($row['created_at'])),
                'amount' => '$' . number_format($row['amount'], 2),
                'status' => $row['status'],
                'status_class' => $status_class
            ];
        }

        return $transactions;
    }
    
    public function get_quick_transfer_users() {
        $this->db->select('avatar');
        $this->db->from('users');
        $this->db->where('avatar IS NOT NULL');
        $this->db->where('role', 'customer');
        $this->db->limit(4);
        $query = $this->db->get();

        $avatars = [];
        foreach ($query->result() as $row) {
            $avatars[] = $row->avatar;
        }

        // Fallback if not enough avatars in DB
        if (count($avatars) < 4) {
            return [
                'https://i.pravatar.cc/150?img=32',
                'https://i.pravatar.cc/150?img=12',
                'https://i.pravatar.cc/150?img=43',
                'https://i.pravatar.cc/150?img=54'
            ];
        }

        return $avatars;
    }
}
