<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_m extends CI_Model {

    private $table = 'notifikasi';

    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_user($username, $level, $limit = 5)
    {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->where('untuk_username', $username);
        if (!empty($level)) {
            $this->db->or_where('untuk_level', $level);
            $this->db->or_where('untuk_level', 'all');
        }
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function count_unread($username, $level)
    {
        $this->db->from($this->table);
        $this->db->where('is_read', '0');
        $this->db->group_start();
        $this->db->where('untuk_username', $username);
        if (!empty($level)) {
            $this->db->or_where('untuk_level', $level);
            $this->db->or_where('untuk_level', 'all');
        }
        $this->db->group_end();
        return $this->db->count_all_results();
    }

    public function get_unread_by_user($username, $level, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where('is_read', '0');
        $this->db->group_start();
        $this->db->where('untuk_username', $username);
        if (!empty($level)) {
            $this->db->or_where('untuk_level', $level);
            $this->db->or_where('untuk_level', 'all');
        }
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, ['id_notifikasi' => $id])->row_array();
    }

    public function mark_read($id)
    {
        return $this->db->update($this->table, ['is_read' => '1'], ['id_notifikasi' => $id]);
    }
}
