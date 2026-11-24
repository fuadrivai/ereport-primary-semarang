<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_eyes extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->sespre = $this->config->item('session_name_prefix');

        $this->d['admlevel'] = $this->session->userdata($this->sespre . 'level');
        $this->d['url'] = "school_eyes";
        $this->d['idnya'] = "schooleyes";
        $this->d['nama_form'] = "f_schooleyes";
        
        // Cek login, kecuali untuk API
        if ($this->router->fetch_method() != 'api') {
            cek_aktif();
        }
    }

    public function index()
    {
        $this->d['p'] = "list";
        $this->load->view("template_utama", $this->d);
    }

    public function datatable()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $draw = $this->input->post('draw');
        $search = $this->input->post('search');

        $where = "WHERE name LIKE '%" . $search['value'] . "%'";
        $d_total_row = $this->db->query("SELECT id FROM m_school_eyes " . $where)->num_rows();

        $q_datanya = $this->db->query("SELECT * FROM m_school_eyes " . $where . " ORDER BY id DESC LIMIT " . $start . ", " . $length . "")->result_array();
        
        $current_day = date('l');
        $current_time = date('H:i:s', strtotime('-1 hour'));
        
        $data = array();
        $no = ($start + 1);

        foreach ($q_datanya as $d) {
            $days_arr = explode(',', $d['days']);
            $is_active_day = in_array($current_day, $days_arr);
            $is_active_time = ($current_time >= $d['time_from'] && $current_time <= $d['time_until']);
            
            $status_badge = '<span class="label label-default">Inactive</span>';
            if ($is_active_day && $is_active_time) {
                $status_badge = '<span class="label label-success animate-pulse" style="background-color: #2ecc71; border: none;"><i class="fa fa-circle"></i> Live</span>';
            } else if ($is_active_day) {
                $status_badge = '<span class="label label-warning" style="background-color: #f1c40f; border: none;"><i class="fa fa-clock-o"></i> Scheduled Today</span>';
            }

            $day_badges = '';
            $days_map = array('Monday'=>'Mon', 'Tuesday'=>'Tue', 'Wednesday'=>'Wed', 'Thursday'=>'Thu', 'Friday'=>'Fri', 'Saturday'=>'Sat', 'Sunday'=>'Sun');
            foreach ($days_arr as $day) {
                $short_day = isset($days_map[$day]) ? $days_map[$day] : $day;
                $active_class = ($day == $current_day) ? 'label-info' : 'label-default';
                $day_badges .= '<span class="label '.$active_class.'" style="margin-right:2px; font-weight: normal;">'.$short_day.'</span>';
            }

            $data_ok = array();
            $data_ok[0] = '<div class="text-center">'.$no++.'</div>';
            $data_ok[1] = '<b>'.$d['name'].'</b><br>'.$status_badge;
            $data_ok[2] = '<code style="font-size: 11px; word-break: break-all;">'.$d['url'].'</code>';
            $data_ok[3] = $day_badges;
            $data_ok[4] = '<span class="text-primary" style="font-weight: 500;"><i class="fa fa-clock-o"></i> '.date('H:i', strtotime($d['time_from'])).' - '.date('H:i', strtotime($d['time_until'])).'</span>';

            $data_ok[5] = '<div class="text-center">
                <a href="' . base_url() . $this->d['url'] . '/edit/' . $d['id'] . '" class="btn btn-sm btn-success btn-fill" title="Edit"><i class="fa fa-edit"></i></a>
                <a href="#" onclick="return hapus(\'' . $d['id'] . '\');" class="btn btn-sm btn-danger btn-fill" title="Delete"><i class="fa fa-remove"></i></a>
                </div>';

            $data[] = $data_ok;
        }

        $json_data = array(
            "draw" => $draw,
            "iTotalRecords" => $d_total_row,
            "iTotalDisplayRecords" => $d_total_row,
            "data" => $data
        );
        j($json_data);
        exit;
    }

    public function edit($id = "")
    {
        if ($id == "") {
            $this->d['data'] = array(
                'id' => '',
                'name' => '',
                'url' => '',
                'days' => '',
                'time_from' => '07:00',
                'time_until' => '15:00',
                'mode' => 'add'
            );
        } else {
            $q = $this->db->query("SELECT *, 'edit' AS mode FROM m_school_eyes WHERE id = '$id'")->row_array();
            $this->d['data'] = $q;
        }

        $this->d['p'] = "form";
        $this->load->view("template_utama", $this->d);
    }

    public function simpan()
    {
        $p = $this->input->post();
        
        $days = isset($p['days']) ? implode(',', $p['days']) : '';

        $data = array(
            'name' => $p['name'],
            'url' => $p['url'],
            'days' => $days,
            'time_from' => $p['time_from'],
            'time_until' => $p['time_until']
        );

        if ($p['_mode'] == "add") {
            $this->db->insert('m_school_eyes', $data);
        } else {
            $this->db->where('id', $p['_id']);
            $this->db->update('m_school_eyes', $data);
        }

        redirect($this->d['url']);
    }

    public function hapus($id)
    {
        $this->db->query("DELETE FROM m_school_eyes WHERE id = '$id'");
        redirect($this->d['url']);
    }

    public function api()
    {
        // Set timezone if needed, usually CI config handles it
        $current_day = date('l'); // Sunday, Monday, etc.
        $current_time = date('H:i:s', strtotime('-1 hour'));

        $all_streams = $this->db->query("SELECT * FROM m_school_eyes")->result_array();
        
        $active_streams = array();
        
        foreach ($all_streams as $s) {
            $days_arr = explode(',', $s['days']);
            if (in_array($current_day, $days_arr)) {
                if ($current_time >= $s['time_from'] && $current_time <= $s['time_until']) {
                    $active_streams[] = $s;
                }
            }
        }

        j(array(
            'status' => 'success',
            'server_time' => $current_time,
            'server_day' => $current_day,
            'data' => $active_streams
        ));
    }
}
