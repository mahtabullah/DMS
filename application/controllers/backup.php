<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backup extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('backup/index');
    }

    public function getNewBackup() {
        $this->createBackup();
        $list = $this->getDownloadList(5);
        echo $list;
    }

    public function downloadList() {
        $list = $this->getDownloadList();
        echo $list;
    }

    public function getDownloadList() {
        $file_list = $this->getDownloadLink(5);

        $html = "";
        foreach ($file_list as $k => $v) {
            $file = explode("/", $v);
            $file_size = sizeof($file);
            $html .= '<tr>';
            $html .= '<td>' . ($k + 1) . '</td>';
            $html .= '<td>' . $file[$file_size - 1] . '</td>';
            $html .= '<td><a class="btn btn-large green" href="' . $v . '"><i class="fa fa-download"></i> Download </a></td>';
            $html .= '</tr>';
        }

        return $html;
    }

    public function createBackup() {

        $backup_directory = "/var/www/html/uploads/database_backup";
        $file_name = 'es_transcom_' . date('Y_m_d_h_i_s_A') . '.sql';
        $file_location = $backup_directory . '/' . $file_name;

        $cmd = "mysqldump -h 45.64.135.133 -u root -pba@!2345 es_transcom > $file_location";

        $result = shell_exec($cmd);
        return $result;
    }


    public function getDownloadLink($file_limit = 5) {
        $list = array();
        $files = glob('uploads/database_backup/*.sql');
        $j = 0;
        for ($i = sizeof($files); $i > 0; $i--) {
            if ($j == $file_limit) {
                unlink($files[$i - 1]);
                continue;
            }
            array_push($list, base_url() . $files[$i - 1]);
            $j++;
        }
        return $list;
    }

}
