<?php
/*
 * Copyright (C) 2004-2024 Soner Tari
 *
 * This file is part of UTMFW.
 *
 * UTMFW is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * UTMFW is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with UTMFW.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('include.php');

$LogConf = array(
	'ctlr_syslog' => array(
		'Fields' => array(
			'Date' => _TITLE('Date'),
			'Time' => _TITLE('Time'),
			'Prio' => _TITLE('Prio'),
			'File' => _TITLE('File'),
			'Function' => _TITLE('Function'),
			'Line' => _TITLE('Line'),
			'Reason' => _TITLE('Reason'),
			'Log' => _TITLE('Log'),
			),
		'HighlightLogs' => array(
			'Col' => 'Prio',
			'REs' => array(
				'red' => array('LOG_EMERG', 'LOG_ALERT', 'LOG_CRIT', 'LOG_ERR'),
				'yellow' => array('LOG_WARNING'),
				),
			),
		),
	);

class Ctlrlogs extends View
{
	public $Model= 'ctlr_syslog';
	
	function __construct()
	{
		$this->Module= basename(dirname($_SERVER['PHP_SELF']));
		$this->LogsHelpMsg= _HELPWINDOW('PFFW logs errors, warnings, notices, and debug messages. Since also recorded are changes to configuration and passwords, you may want to monitor these logs carefully. These logs are also important while reporting issues related to the web user interface. Logs on this page are generated by the Controller and the Model, middle and bottom layers of software responsible for processing requests from the View.');
	}
	
	function FormatLogCols(&$cols)
	{
		global $ROOT;

		if (isset($cols['File'])) {
			$filepath= $cols['File'];
			if (preg_match("|^($ROOT)(.*)$|", $filepath, $match)) {
				$cols['File']= '<a title="'.$filepath.'">'.$match[2].'</a>';
			}
		}
	}
}

$View= new Ctlrlogs();

require_once('../lib/logs.php');
?>
