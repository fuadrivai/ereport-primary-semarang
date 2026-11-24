<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daily_updates extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->sespre = $this->config->item('session_name_prefix');

        $this->d['admlevel'] = $this->session->userdata($this->sespre . 'level');
        $this->d['konid'] = $this->session->userdata($this->sespre . 'konid');
        $this->d['url'] = "daily_updates";
        $this->d['idnya'] = "dailyupdates";
        $this->d['nama_form'] = "f_dailyupdates";
        
        $method = $this->router->fetch_method();
        if ($method != 'api') {
            cek_aktif();
        }

        $get_tasm = $this->db->query("SELECT tahun FROM tahun WHERE aktif = 'Y'")->row_array();
        $this->d['tasm'] = isset($get_tasm)? substr($get_tasm['tahun'],0,4): date('Y');

        if ($this->d['admlevel'] == 'guru') {
            $q_wali = $this->db->query("SELECT id_kelas FROM t_walikelas WHERE id_guru = '".$this->d['konid']."' AND tasm = '".$this->d['tasm']."'")->row_array();
            $this->d['wali_kelas'] = isset($q_wali['id_kelas']) ? $q_wali['id_kelas'] : null;
        } else {
            $this->d['wali_kelas'] = null;
        }
    }

    public function index()
    {
        if ($this->d['admlevel'] == 'guru') {
            if ($this->d['wali_kelas']) {
                redirect($this->d['url'] . '/students/' . $this->d['wali_kelas']);
            } else {
                echo "Anda belum diset sebagai wali kelas. Silakan hubungi admin.";
                exit;
            }
        } else if ($this->d['admlevel'] == 'siswa') {
            // Students should probably see their own history/updates
            // For now, redirect to a filtered view if it exists, or show a friendly message
            // Based on previous research, we might want to display a student-specific page.
            // Since there isn't one yet, we'll let them see the index or a notice.
            // PROMPT said "add menu", so we primarily focus on sidebar.
        }
        $this->d['p_kelas'] = $this->db->query("SELECT * FROM m_kelas ORDER BY tingkat, nama")->result_array();
        $this->d['p'] = "index";
        $this->load->view("template_utama", $this->d);
    }

    public function students($id_kelas)
    {
        $this->_check_access($id_kelas);
        $date = date('Y-m-d');
        $ta = $this->d['tasm'];
        $this->d['kelas'] = $this->db->query("SELECT * FROM m_kelas WHERE id = '$id_kelas'")->row_array();
        $this->d['students'] = $this->db->query("SELECT a.*, 
                                                m.meal_status as today_meal,
                                                mo.mood as today_mood,
                                                h.status as today_health,
                                                h.details as today_health_details,
                                                (SELECT id FROM t_check_in WHERE student_id = a.id AND date = '$date' LIMIT 1) as is_checkin,
                                                (SELECT id FROM t_check_out WHERE student_id = a.id AND DATE(timestamp) = '$date' LIMIT 1) as is_checkout
                                                FROM m_siswa a 
                                                INNER JOIN t_kelas_siswa b ON a.id = b.id_siswa 
                                                LEFT JOIN t_meal_monitoring m ON a.id = m.student_id AND m.date = '$date'
                                                LEFT JOIN t_mood_observation mo ON a.id = mo.student_id AND mo.date = '$date'
                                                LEFT JOIN t_health_status h ON a.id = h.student_id AND h.date = '$date'
                                                WHERE b.id_kelas = '$id_kelas' AND a.stat_data = 'A' AND b.ta = '$ta'
                                                ORDER BY a.nama ASC")->result_array();
        $this->d['p'] = "students";
        $this->load->view("template_utama", $this->d);
    }

    public function form($type, $student_id)
    {
        $q_student = $this->db->query("SELECT a.*, b.id_kelas FROM m_siswa a 
                                      INNER JOIN t_kelas_siswa b ON a.id = b.id_siswa 
                                      WHERE a.id = '$student_id' AND a.stat_data = 'A'")->row_array();
        
        if (empty($q_student)) {
            echo "Data siswa tidak ditemukan.";
            exit;
        }

        $this->_check_access($q_student['id_kelas']);

        $this->d['student'] = $q_student;
        $this->d['type'] = $type;
        $this->d['id_siswa'] = $student_id;
        
        // Specific forms
        $view = "form_" . $type;
        $this->d['p'] = $view;
        $this->load->view("template_utama", $this->d);
    }

    public function simpan_bulk()
    {
        $p = $this->input->post();
        $this->_check_access($p['id_kelas']);

        $student_ids = isset($p['student_ids']) ? $p['student_ids'] : array();
        $date = date('Y-m-d');
        $teacher_id = $this->session->userdata($this->sespre . 'konid');
        $count = 0;

        foreach ($student_ids as $sid) {
            $has_data = false;
            $data_meal = array();
            $data_mood = array();
            $data_health = array();

            // Save Meal Status
            if (!empty($p['meal_status'][$sid])) {
                $check = $this->db->get_where('t_meal_monitoring', array('student_id' => $sid, 'date' => $date))->row();
                $data_meal = array(
                    'student_id' => $sid,
                    'meal_status' => $p['meal_status'][$sid],
                    'date' => $date,
                    'teacher_id' => $teacher_id
                );
                if ($check) {
                    $this->db->where('id', $check->id);
                    $this->db->update('t_meal_monitoring', $data_meal);
                } else {
                    $this->db->insert('t_meal_monitoring', $data_meal);
                }
                $has_data = true;
            }

            // Save Mood
            if (!empty($p['mood'][$sid])) {
                $check = $this->db->get_where('t_mood_observation', array('student_id' => $sid, 'date' => $date))->row();
                $data_mood = array(
                    'student_id' => $sid,
                    'mood' => $p['mood'][$sid],
                    'date' => $date
                );
                if ($check) {
                    $this->db->where('id', $check->id);
                    $this->db->update('t_mood_observation', $data_mood);
                } else {
                    $this->db->insert('t_mood_observation', $data_mood);
                }
                $has_data = true;
            }

            // Save Health Status
            if (!empty($p['health_status'][$sid])) {
                $check = $this->db->get_where('t_health_status', array('student_id' => $sid, 'date' => $date))->row();
                $data_health = array(
                    'student_id' => $sid,
                    'status' => $p['health_status'][$sid],
                    'details' => isset($p['health_details'][$sid]) ? $p['health_details'][$sid] : '',
                    'date' => $date
                );
                if ($check) {
                    $this->db->where('id', $check->id);
                    $this->db->update('t_health_status', $data_health);
                } else {
                    $this->db->insert('t_health_status', $data_health);
                }
                $has_data = true;
            }

            if ($has_data) $count++;
        }

        $this->session->set_flashdata('k', '<div class="alert alert-success">Bulk update successful for ' . $count . ' students!</div>');
        redirect($this->d['url'] . '/students/' . $p['id_kelas']);
    }

    public function simpan_meal()
    {
        $p = $this->input->post();
        $this->_check_access($p['id_kelas']);
        $date = date('Y-m-d');
        $check = $this->db->get_where('t_meal_monitoring', array('student_id' => $p['student_id'], 'date' => $date))->row();
        
        $data = array(
            'student_id' => $p['student_id'],
            'meal_status' => $p['meal_status'],
            'date' => $date,
            'teacher_id' => $this->session->userdata($this->sespre . 'konid')
        );
        
        if ($check) {
            $this->db->where('id', $check->id);
            $this->db->update('t_meal_monitoring', $data);
        } else {
            $this->db->insert('t_meal_monitoring', $data);
        }
        
        redirect($this->d['url'] . '/students/' . $p['id_kelas']);
    }

    public function simpan_check_in()
    {
        $p = $this->input->post();
        $this->_check_access($p['id_kelas']);
        
        // Photo upload handling
        $photo = "";
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path'] = './upload/daily_updates';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '5000';
            $config['file_name'] = 'CI_' . $p['student_id'] . '_' . date('YmdHis');
            $this->load->library('upload', $config);
            
            if (!is_dir('./upload/daily_updates')) {
                mkdir('./upload/daily_updates', 0777, TRUE);
            }

            if ($this->upload->do_upload('photo')) {
                $ud = $this->upload->data();
                $photo = $ud['file_name'];
                $this->_compress_image($ud['full_path']);
            }
        }

        $data = array(
            'student_id' => $p['student_id'],
            'photo' => $photo,
            'class_id' => $p['id_kelas'],
            'date' => date('Y-m-d')
        );
        $this->db->insert('t_check_in', $data);
        
        // Real-time Push Notification (Trigger)
        $this->_send_notification($p['student_id'], "Check-In", "Student has successfully checked in.");
        
        redirect($this->d['url'] . '/students/' . $p['id_kelas']);
    }

    public function simpan_check_out()
    {
        $p = $this->input->post();
        $this->_check_access($p['id_kelas']);
        
        // Photo upload handling
        $photo = "";
        if (!empty($_FILES['photo']['name'])) {
            $config['upload_path'] = './upload/daily_updates';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '5000';
            $config['file_name'] = 'CO_' . $p['student_id'] . '_' . date('YmdHis');
            $this->load->library('upload', $config);
            
            if (!is_dir('./upload/daily_updates')) {
                mkdir('./upload/daily_updates', 0777, TRUE);
            }

            if ($this->upload->do_upload('photo')) {
                $ud = $this->upload->data();
                $photo = $ud['file_name'];
                $this->_compress_image($ud['full_path']);
            }
        }

        $data = array(
            'student_id' => $p['student_id'],
            'photo' => $photo,
            'summary_inclusion' => isset($p['summary_inclusion']) ? 1 : 0
        );
        $this->db->insert('t_check_out', $data);
        
        // Notification at dismissal
        $this->_send_notification($p['student_id'], "Check-Out", "Student has successfully checked out.");
        
        redirect($this->d['url'] . '/students/' . $p['id_kelas']);
    }

    public function simpan_mood()
    {
        $p = $this->input->post();
        $this->_check_access($p['id_kelas']);
        $date = date('Y-m-d');
        $check = $this->db->get_where('t_mood_observation', array('student_id' => $p['student_id'], 'date' => $date))->row();
        
        $data = array(
            'student_id' => $p['student_id'],
            'mood' => $p['mood'],
            'date' => $date
        );
        
        if ($check) {
            $this->db->where('id', $check->id);
            $this->db->update('t_mood_observation', $data);
        } else {
            $this->db->insert('t_mood_observation', $data);
        }
        
        redirect($this->d['url'] . '/students/' . $p['id_kelas']);
    }

    public function simpan_health()
    {
        $p = $this->input->post();
        $this->_check_access($p['id_kelas']);
        $date = date('Y-m-d');
        $check = $this->db->get_where('t_health_status', array('student_id' => $p['student_id'], 'date' => $date))->row();
        
        $data = array(
            'student_id' => $p['student_id'],
            'status' => $p['status'],
            'details' => $p['details'],
            'date' => $date
        );
        
        if ($check) {
            $this->db->where('id', $check->id);
            $this->db->update('t_health_status', $data);
        } else {
            $this->db->insert('t_health_status', $data);
        }
        
        redirect($this->d['url'] . '/students/' . $p['id_kelas']);
    }

    private function _compress_image($file_path)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file_path;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 600;
        $config['height'] = 600;
        $config['quality'] = '60%';

        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            log_message('error', $this->image_lib->display_errors());
        }
        $this->image_lib->clear();
    }

    private function _check_access($id_kelas)
    {
        if ($this->d['admlevel'] == 'guru' && $this->d['wali_kelas'] != $id_kelas) {
            echo "Akses ditolak. Anda hanya diperbolehkan mengakses kelas Anda sendiri.";
            exit;
        }
    }

    private function _send_notification($student_id, $type, $message)
    {
        // Placeholder for notification system
        // This can be integrated with OneSignal, FCM, or any push service.
        log_message('debug', "Notification sent for Student ID $student_id: [$type] $message");
    }

    public function api()
    {
        $nis = $this->input->get('nis');
        $month = $this->input->get('month'); // Expecting YYYY-MM

        if (empty($nis)) {
            j(['status' => 'error', 'message' => 'NIS parameter is required']);
            return;
        }

        // Get student by NIS
        $student = $this->db->get_where('m_siswa', ['nis' => $nis])->row_array();
        
        if (empty($student)) {
            j(['status' => 'error', 'message' => 'Student not found with NIS: ' . $nis]);
            return;
        }

        $student_id = $student['id'];

        // Helper function for filtered queries
        $get_filtered = function($table, $student_id, $month, $latest_per_day = false) {
            $this->db->where('student_id', $student_id);
            if ($month) {
                // Table t_check_out uses 'timestamp' column, others use 'date'
                $date_column = ($table == 't_check_out') ? 'timestamp' : 'date';
                $this->db->like($date_column, $month, 'after');
            }
            if ($latest_per_day) {
                $this->db->order_by('id', 'DESC');
            }
            $records = $this->db->get($table)->result_array();

            if ($latest_per_day) {
                $filtered_records = [];
                $seen_dates = [];
                $date_column = ($table == 't_check_out') ? 'timestamp' : 'date';
                foreach ($records as $row) {
                    if (isset($row[$date_column])) {
                        $date_only = substr($row[$date_column], 0, 10);
                        if (!isset($seen_dates[$date_only])) {
                            $seen_dates[$date_only] = true;
                            $filtered_records[] = $row;
                        }
                    }
                }
                return $filtered_records;
            }
            return $records;
        };

        $check_in = $get_filtered('t_check_in', $student_id, $month, true);
        $check_out = $get_filtered('t_check_out', $student_id, $month, true);

        // Add full photo URLs
        $upload_path = base_url('upload/daily_updates/');
        
        foreach ($check_in as &$ci) {
            $ci['photo_url'] = !empty($ci['photo']) ? $upload_path . $ci['photo'] : null;
        }
        
        foreach ($check_out as &$co) {
            $co['photo_url'] = !empty($co['photo']) ? $upload_path . $co['photo'] : null;
        }

        $res = array(
            'student_info' => [
                'id' => $student['id'],
                'nis' => $student['nis'],
                'nama' => $student['nama']
            ],
            'meals' => $get_filtered('t_meal_monitoring', $student_id, $month),
            'check_in' => $check_in,
            'check_out' => $check_out,
            'moods' => $get_filtered('t_mood_observation', $student_id, $month),
            'health' => $get_filtered('t_health_status', $student_id, $month)
        );

        j($res);
    }
}
