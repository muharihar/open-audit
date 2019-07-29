<?php
#
#  Copyright 2003-2015 Opmantek Limited (www.opmantek.com)
#
#  ALL CODE MODIFICATIONS MUST BE SENT TO CODE@OPMANTEK.COM
#
#  This file is part of Open-AudIT.
#
#  Open-AudIT is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as published
#  by the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  Open-AudIT is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
#
#  You should have received a copy of the GNU Affero General Public License
#  along with Open-AudIT (most likely in a file named LICENSE).
#  If not, see <http://www.gnu.org/licenses/>
#
#  For further information on Open-AudIT or for a license other than AGPL please see
#  www.opmantek.com or email contact@opmantek.com
#
# *****************************************************************************
$this->benchmark->mark('code_start');

// load our required helpers
$this->load->helper('log');
$this->load->helper('error');

$log = new stdClass();

if (strtoupper($this->input->server('REQUEST_METHOD')) == 'GET') {
    $get = $this->input->get();
    if (!empty($get)) {
        foreach ($get as $key => $value) {
            $input->$key = $value;
        }
    }
} else if (strtoupper($this->input->server('REQUEST_METHOD')) == 'POST') {
    $post = $this->input->post();
    if (!empty($post)) {
        foreach ($post as $key => $value) {
            $log->$key = $value;
        }
    }
}

if (!empty($log->type) and $log->type == 'discovery') {
    $log_id = discovery_log($log);
    if (strpos($log->command_status, ' of ') !== false) {
        # PROGRESS
        $progress = str_replace('(', '', $log->command_status);
        $progress = str_replace(')', '', $progress);
        $sql = '/* input::logs */ ' . "UPDATE `discoveries` SET `discovered` = ?, `last_log` = (SELECT `timestamp` FROM discovery_log WHERE `id` = ?) WHERE id = ?";
        $data = array($progress, $log_id, $log->discovery_id);
        $query = $this->db->query($sql, $data);
    }
    if (strpos($log->message, 'Completed discovery') !== false) {
        # STATUS
        $sql = '/* input::logs */ ' . "UPDATE `discoveries` SET `status` = 'complete' WHERE id = ?";
        $data = array($log->discovery_id);
        $query = $this->db->query($sql, $data);
    } else {
        # STATUS
        $sql = '/* input::logs */ ' . "UPDATE `discoveries` SET `status` = 'running' WHERE `id` = ?";
        $data = array($log->discovery_id);
        $query = $this->db->query($sql, $data);
    }

    $sql = '/* input::logs */ ' . "UPDATE discoveries SET `duration` = TIMEDIFF(last_log, last_run) WHERE id = ?";
    $data = array($log->discovery_id);
    $query = $this->db->query($sql, $data);

    $sql = '/* input::logs */ ' . "UPDATE `discoveries` SET `status` = 'zombie' WHERE `last_log` < (NOW() - INTERVAL 20 MINUTE) AND `last_log` != '2000-01-01 00:00:00' AND `status` != 'complete'";
    $query = $this->db->query($sql);
    # TODO - check the discovery PID (discovery_log.pid) and kill it if required

}

if ($this->response->meta->format == 'json') {
    print_r(json_encode($input));
}

# If we are a collector, forward the log
if ($this->config->config['servers'] !== '' and $log->type == 'discovery') {
    foreach ( $log as $key => $value) {
        $post_items[] = $key . '=' . $value;
    }
    $post = implode ('&', $post_items);
    $server = json_decode($this->config->config['servers']);
    if (!empty($server->host) and !empty($server->community)) {
        $connection = curl_init($server->host . $server->community . '/index.php/input/devices');
        curl_setopt($connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($connection, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($connection);
        if (curl_errno($connection)) {
            $log->message = 'Failed to send log to ' . $server->host;
            $log->severity = 4;
            $log->command = json_encode(curl_getinfo($connection));
            $log->command_output = curl_errno($connection) . ' - ' . curl_error($connection);
            discovery_log($log);
        }
        curl_close($connection);
    }
}

exit();
