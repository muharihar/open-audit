<?php
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

/**
 * @author Mark Unwin <marku@opmantek.com>
 *
 * @version   2.0.1

 *
 * @copyright Copyright (c) 2014, Opmantek
 * @license http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><?php echo __("Default Queries"); ?></h3></div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>SQL</th>
                </tr>
            </thead>
            <tbody>

                <tr><td>Audit Dates</td><td style="word-wrap: break-word; white-space: pre-wrap; min-width: 350px;">The first and last times a device was audited.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.os_name AS `system.os_name`, system.first_seen AS `system.first_seen`, system.last_seen AS `system.last_seen`, GROUP_CONCAT(DISTINCT(audit_log.type) ORDER BY audit_log.type) AS `seen_by` FROM system LEFT JOIN audit_log ON (audit_log.system_id = system.id) WHERE @filter GROUP BY system.id</pre></td></tr>

                <tr><td>Billing Report</td><td style="word-wrap: break-word; white-space: pre-wrap;">Name, last seen on and by, type, class, manufacturer, model, serial, user, location.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, orgs.name AS `orgs.name`, system.last_seen AS `system.last_seen`, system.last_seen_by AS `system.last_seen_by`, system.manufacturer AS `system.manufacturer`, system.model AS `system.model`, system.serial AS `system.serial`, system.class AS `system.class`, windows.user_name AS `windows.user_name`, locations.name AS `locations.name` FROM system LEFT JOIN locations ON (system.location_id = locations.id) LEFT JOIN windows ON (system.id = windows.system_id AND windows.current = 'y') LEFT JOIN orgs ON (system.org_id = orgs.id) WHERE @filter</pre></td></tr>

                <tr><td>Changes - Files</td><td style="word-wrap: break-word; white-space: pre-wrap;">Any changes created in the tables 'file'.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">Any changes in the table 'file'.", "SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, change_log.timestamp AS `change_log.timestamp`, change_log.db_table AS `change_log.db_table`, change_log.db_action AS `change_log.db_action`, change_log.details AS `change_log.details`, change_log.id AS `change_log.id` FROM change_log LEFT JOIN system ON (change_log.system_id = system.id) WHERE @filter AND change_log.ack_time = '2001-01-01 00:00:00' AND change_log.db_table = 'files'</pre></td></tr>

                <tr><td>Changes - Hardware</td><td style="word-wrap: break-word; white-space: pre-wrap;">Any changes created in the tables 'bios', 'disk', 'memory', 'module', 'monitor', 'motherboard', 'optical', 'partition', 'processor', 'network', 'scsi', 'sound' and 'video'.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, change_log.timestamp AS `change_log.timestamp`, change_log.db_table AS `change_log.db_table`, change_log.db_action AS `change_log.db_action`, change_log.details AS `change_log.details`, change_log.id AS `change_log.id` FROM change_log LEFT JOIN system ON (change_log.system_id = system.id) WHERE @filter AND change_log.ack_time = '2001-01-01 00:00:00' AND change_log.db_table in ('bios', 'disk', 'memory', 'module', 'monitor', 'motherboard', 'optical', 'partition', 'processor', 'network', 'scsi', 'sound', 'video')</pre></td></tr>

                <tr><td>Changes - New Devices</td><td style="word-wrap: break-word; white-space: pre-wrap;">Any changes in the table 'system'.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, change_log.timestamp AS `change_log.timestamp`, change_log.db_table AS `change_log.db_table`, change_log.db_action AS `change_log.db_action`, change_log.details AS `change_log.details`, change_log.id AS `change_log.id` FROM change_log LEFT JOIN system ON (change_log.system_id = system.id) WHERE @filter AND change_log.ack_time = '2001-01-01 00:00:00' AND change_log.db_table = 'system'</pre></td></tr>

                <tr><td>Changes - Settings</td><td style="word-wrap: break-word; white-space: pre-wrap;">Any changes in the tables 'dns', 'ip', 'log', netstat', 'pagefile', 'print_queue', 'route', 'task', 'user', 'user_group' and 'variable'.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, change_log.timestamp AS `change_log.timestamp`, change_log.db_table AS `change_log.db_table`, change_log.db_action AS `change_log.db_action`, change_log.details AS `change_log.details`, change_log.id AS `change_log.id` FROM change_log LEFT JOIN system ON (change_log.system_id = system.id) WHERE @filter AND change_log.ack_time = '2001-01-01 00:00:00' AND change_log.db_table in ('dns', 'ip', 'log', 'netstat', 'pagefile', 'print_queue', 'route', 'task', 'user', 'user_group', 'variable')</pre></td></tr>

                <tr><td>Changes - Software</td><td style="word-wrap: break-word; white-space: pre-wrap;">Any changes in the tables 'service', 'server', 'server_item', 'software' and 'software_key'.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, change_log.timestamp AS `change_log.timestamp`, change_log.db_table AS `change_log.db_table`, change_log.db_action AS `change_log.db_action`, change_log.details AS `change_log.details`, change_log.id AS `change_log.id` FROM change_log LEFT JOIN system ON (change_log.system_id = system.id) WHERE change_log.ack_time = '2001-01-01 00:00:00' AND change_log.db_table in ('service', 'server', 'server_item', 'software', 'software_key')</pre></td></tr>

                <tr><td>Consumed IP Addresses</td><td style="word-wrap: break-word; white-space: pre-wrap;">The ip addresses used by a group.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.os_family AS `system.os_family`, system.description AS `system.description`, ip.ip as `ip.ip` FROM ip LEFT JOIN system ON (system.id = ip.system_id AND ip.current = 'y') WHERE @filter AND ip.ip IS NOT NULL AND ip.ip != '127.000.000.001' AND ip.ip != '' AND ip.ip != '0.0.0.0' AND ip.ip != '000.000.000.000' AND ip.version = '4' GROUP BY ip.id, ip.ip ORDER BY ip.ip</pre></td></tr>

                <tr><td>Devices Without Credentials</td><td style="word-wrap: break-word; white-space: pre-wrap;">Device details - name, ip, last seen on and by for those devices only discovered by Nmap and have therefore not been audited.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, audit_log.timestamp AS `audit_log.timestamp`, audit_log.ip AS `audit_log.ip` FROM audit_log LEFT JOIN system ON (audit_log.system_id = system.id) WHERE @filter AND audit_log.system_id NOT IN (SELECT DISTINCT(audit_log.system_id) FROM audit_log WHERE type != 'nmap') GROUP BY system.id</pre></td></tr>

                <tr><td>Disk Partition Use</td><td style="word-wrap: break-word; white-space: pre-wrap;">Partition details where partition free and used space aren't 0 and type isn't Volume or Network Drive and mount point isn't [SWAP].</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, partition.id AS `partition.id`, partition.hard_drive_index AS `partition.hard_drive_index`, partition.mount_point AS `partition.mount_point`, partition.mount_type as `partition.mount_type`, partition.size AS `partition.size`, partition.used AS `partition.used`, partition.free AS `partition.free`, ROUND(((partition.free / partition.size) * 100), 0) AS percent_free, partition.name AS `partition.name` FROM system INNER JOIN `partition` ON (partition.system_id = system.id AND partition.current = 'y') WHERE @filter AND partition.used > 0 AND partition.free > 0 AND LOWER(partition.type) != 'volume' AND LOWER(partition.type) != 'network drive' AND LOWER(partition.mount_point) != '[swap]' ORDER BY system.name, partition.id</pre></td></tr>

                <tr><td>Export Details</td><td style="word-wrap: break-word; white-space: pre-wrap;">Icon, type, name, first seen on, last seen on, last seen by, manufacturer, model, serial, owner, organisation, location, operating system.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.fqdn AS `system.fqdn`, system.serial AS `system.serial`, system.class AS `system.class`, system.function AS `system.function`, system.owner AS `system.owner`, system.asset_number AS `system.asset_number` FROM system WHERE @filter</pre></td></tr>

                <tr><td>Failed Audits</td><td style="word-wrap: break-word; white-space: pre-wrap;">Name, ip address, audit time, audit stage.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, audit_log.timestamp AS `audit_log.timestamp`, audit_log.debug AS `audit_log.debug` FROM system LEFT JOIN audit_log ON (system.id = audit_log.system_id) WHERE @filter AND audit_log.debug > ''</pre></td></tr>

                <tr><td>Hardware - Device</td><td style="word-wrap: break-word; white-space: pre-wrap;">Icon, name, ip address, manufacturer, model, serial.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.manufacturer AS `system.manufacturer`, system.model AS `system.model`, system.serial AS `system.serial`, system.os_family AS `system.os_family`, system.asset_number AS `system.asset_number` FROM system WHERE @filter</pre></td></tr>

                <tr><td>Hardware - Memory and Processors</td><td style="word-wrap: break-word; white-space: pre-wrap;">Device details - name, ip, memory, total processor cores, processor speed, processor description.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, CAST(system.memory_count/1024 AS UNSIGNED) AS `system.memory_count`, processor.physical_count AS `processor.physical_count`, processor.core_count AS `processor.core_count`, processor.logical_count AS `processor.logical_count`, processor.speed AS `processor.speed`, processor.description AS `processor.description` FROM system INNER JOIN processor ON (system.id = processor.system_id AND processor.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Hardware - Workstations</td><td style="word-wrap: break-word; white-space: pre-wrap;">Device details - name, ip, manufacturer, model, serial, form factor, memory, processor.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.manufacturer AS `system.manufacturer`, system.model AS `system.model`, system.serial AS `system.serial`, system.os_family AS `system.os_family`, system.memory_count AS `system.memory_count`, system.form_factor AS `system.form_factor`, processor.description AS `processor.description` FROM system LEFT JOIN processor ON (processor.system_id = system.id AND processor.current = 'y') WHERE @filter AND system.type = 'computer' AND system.class != 'server' AND system.class != 'hypervisor' ORDER BY system.name</pre></td></tr>

                <tr><td>Installed - Acrobat</td><td style="word-wrap: break-word; white-space: pre-wrap;">Adobe Acrobat installations (software name contains 'acrobat' or 'adobe reader').</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version`, software.id as `software.id` FROM software LEFT JOIN system ON (software.system_id = system.id AND software.current = 'y' AND (software.name LIKE '%acrobat%' OR software.name LIKE 'adobe reader%')) LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Installed - Antivirus</td><td style="word-wrap: break-word; white-space: pre-wrap;">Installed AntiVirus software (software name contains 'virus' or 'trend micro' or 'endpoint').</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version` FROM system LEFT JOIN software ON (software.system_id = system.id AND software.current = 'y' AND (software.name LIKE '%virus%' or software.name LIKE '%trend micro%' or software.name LIKE '%endpoint%')) LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter AND system.type = 'computer'</pre></td></tr>

                <tr><td>Installed - Flash</td><td style="word-wrap: break-word; white-space: pre-wrap;">Flash Player installations.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version`, software.id as `software.id` FROM software LEFT JOIN system ON (software.system_id = system.id AND software.current = 'y' AND software.name LIKE '%Flash Player%') LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Installed - MS FrontPage</td><td style="word-wrap: break-word; white-space: pre-wrap;">MS Frontpage installations (software name contains 'Microsoft Office Frontpage' or 'with Frontpage').</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version`, software.id as `software.id` FROM software LEFT JOIN system ON (software.system_id = system.id AND software.current = 'y' AND (software.name LIKE 'Microsoft Office Frontpage%' OR software.name LIKE '%with FrontPage')) LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Installed - MS Office</td><td style="word-wrap: break-word; white-space: pre-wrap;">MS Office installations.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version`, software.id as `software.id` FROM software LEFT JOIN system ON (software.system_id = system.id AND software.current = 'y' AND software.name LIKE 'Microsoft Office%') LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Installed - MS Project</td><td style="word-wrap: break-word; white-space: pre-wrap;">MS Project installations (software name contains 'Microsoft Project').</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version`, software.id as `software.id` FROM software LEFT JOIN system ON (software.system_id = system.id AND software.current = 'y' AND software.name LIKE '%Microsoft%Project%') LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Installed - MS Visio</td><td style="word-wrap: break-word; white-space: pre-wrap;">MS Visio installations (software name contains 'Microsoft Visio').</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.class AS `system.class`, system.os_family AS `system.os_family`, orgs.name AS `orgs.name`, windows.user_name AS `windows.user_name`, software.name as `software.name`, software.version AS `software.version`, software.id as `software.id` FROM software LEFT JOIN system ON (software.system_id = system.id AND software.current = 'y' AND software.name LIKE 'Microsoft%Visio%') LEFT JOIN orgs ON (orgs.id = system.org_id) LEFT JOIN windows ON (windows.system_id = system.id AND windows.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Interfaces Used or Available</td><td style="word-wrap: break-word; white-space: pre-wrap;">Query to determine if a device interface is available for use.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, network.alias as `network.alias`, network.net_index AS `network.net_index`, network.description as `network.description`, network.ifadminstatus as `network.ifadminstatus`, network.ip_enabled as `network.ip_enabled`, system.sysuptime AS `system.sysuptime`, (system.sysuptime - network.iflastchange) AS diff, floor((system.sysuptime - network.iflastchange) /60/60/24/100) as diff_days, IF((network.ifadminstatus = 'down') OR (network.ifadminstatus = 'up' AND (network.ip_enabled != 'up' AND network.ip_enabled != 'dormant') AND (((system.sysuptime - network.iflastchange) > 60480000) OR (system.sysuptime &lt; network.iflastchange))), 'available', 'used') AS available FROM network LEFT JOIN system ON (network.system_id = system.id AND network.current = 'y') WHERE @filter AND network.ifadminstatus != ''</pre></td></tr>

                <tr><td>Log Files</td><td style="word-wrap: break-word; white-space: pre-wrap;">Log file details.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, log.name as `log.name`, log.file_name AS `log.file_name`, log.file_size AS `log.file_size`, log.max_file_size AS `log.max_file_size`, log.overwrite AS `log.overwrite` FROM log LEFT JOIN system ON (system.id = log.system_id and log.current = 'y') WHERE @filter ORDER BY system.name</pre></td></tr>

                <tr><td>Netstat Ports</td><td style="word-wrap: break-word; white-space: pre-wrap;">Detected Netstat ports.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.os_name AS `system.os_name`, netstat.protocol AS `netstat.protocol`, netstat.port AS `netstat.port`, netstat.ip AS `netstat.ip`, netstat.program AS `netstat.program` FROM system LEFT JOIN netstat ON (system.id = netstat.system_id AND netstat.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Printer Queues</td><td style="word-wrap: break-word; white-space: pre-wrap;">Printer details - manufacturer, model, status, capabilities, etc.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, print_queue.manufacturer AS `print_queue.manufacturer`, print_queue.model AS `print_queue.model`, print_queue.description AS `print_queue.description`, print_queue.driver AS `print_queue.driver`, print_queue.status AS `print_queue.status`, print_queue.port_name AS `print_queue.port_name`, print_queue.duplex AS `print_queue.duplex`, print_queue.color AS `print_queue.color`, print_queue.location AS `print_queue.location`, print_queue.type AS `print_queue.type`, print_queue.shared AS `print_queue.shared`, print_queue.shared_name AS `print_queue.shared_name`, print_queue.capabilities AS `print_queue.capabilities` FROM print_queue LEFT JOIN system ON (system.id = print_queue.system_id AND print_queue.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Servers - Database</td><td style="word-wrap: break-word; white-space: pre-wrap;">All databases.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.name AS `system.name`, system.fqdn AS `system.fqdn`, system.os_family AS `system.os_family`, system.environment AS `system.environment`, server_item.parent_name AS `server_item.parent_name`, server_item.name AS `server_item.name`, server_item.instance AS `server_item.instance`, server_item.path AS `server_item.path`, server_item.log_status AS `server_item.log_status`, server_item.log_format AS `server_item.log_format`, server_item.log_rotation AS `server_item.log_rotation`, server_item.log_path AS `server_item.log_path` FROM system LEFT JOIN server_item ON (server_item.system_id = system.id and server_item.current = 'y') WHERE @filter AND server_item.type = 'database'</pre></td></tr>

                <tr><td>Servers - Websites</td><td></td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, system.os_family AS `system.os_family`, system.environment AS `system.environment`, server_item.parent_name AS `server_item.parent_name`, server_item.name AS `server_item.name`, server_item.description AS `server_item.description`, server_item.status AS `server_item.status`, server_item.instance AS `server_item.instance`, server_item.path AS `server_item.path`, server_item.log_status AS `server_item.log_status`, server_item.log_format AS `server_item.log_format`, server_item.log_rotation AS `server_item.log_rotation`, server_item.log_path AS `server_item.log_path` FROM system LEFT JOIN server_item ON (server_item.system_id = system.id and server_item.current = 'y') WHERE @filter AND server_item.type = 'website'</pre></td></tr>

                <tr><td>Shares</td><td style="word-wrap: break-word; white-space: pre-wrap;">Shared directory details.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, share.id AS `share.id`, share.name AS `share.name`, share.description AS `share.description`, share.size AS `share.size`, share.path AS `share.path` FROM share LEFT JOIN system ON (system.id = share.system_id and share.current = 'y') WHERE @filter</pre></td></tr>

                <tr><td>Users - Elevated</td><td style="word-wrap: break-word; white-space: pre-wrap;">Name, group name, group members.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, user_group.name as `user_group.name`, user_group.members AS `user_group.members` FROM user_group LEFT JOIN system ON (user_group.system_id = system.id AND user_group.current = 'y') WHERE @filter AND (user_group.name = 'Administrators' OR user_group.name = 'Power Users' OR user_group.name = 'Remote Desktop Users' OR user_group.name = 'wheel' OR user_group.name = 'sudo') AND user_group.members > '' GROUP BY system.id, user_group.name ORDER BY system.name</pre></td></tr>

                <tr><td>Users - Orphaned</td><td style="word-wrap: break-word; white-space: pre-wrap;">User accounts that no longer appear to be valid.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, user_group.name as `user_group.name`, user_group.members AS `user_group.members` FROM system LEFT JOIN user_group ON (user_group.system_id = system.id AND user_group.current = 'y') WHERE @filter AND user_group.members LIKE '%@,%' AND user_group.members NOT LIKE 'Everyone@,' GROUP BY user_group.id ORDER BY system.name</pre></td></tr>

                <tr><td>Users - Standard</td><td style="word-wrap: break-word; white-space: pre-wrap;">Name, group name, group members.</td><td><pre style="word-wrap: break-word; white-space: pre-wrap;">SELECT system.id AS `system.id`, system.icon AS `system.icon`, system.type AS `system.type`, system.name AS `system.name`, system.domain AS `system.domain`, system.ip AS `system.ip`, user_group.members AS `user_group.members`, user_group.name AS `user_group.name` FROM user_group LEFT JOIN system ON (user_group.system_id = system.id AND user_group.current = 'y') WHERE @filter AND (user_group.name = 'Users' OR user_group.name = 'Guests') AND user_group.members > ''</pre></td></tr>
            </tbody>
        </table>
    </div>
</div>