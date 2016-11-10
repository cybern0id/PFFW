<?php
/*
 * Copyright (C) 2004-2016 Soner Tari
 *
 * This file is part of PFFW.
 *
 * PFFW is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PFFW is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PFFW.  If not, see <http://www.gnu.org/licenses/>.
 */

/** @file
 * All live log pages include this file.
 *
 * Includes a different top menu if so configured. Currently only for pf.
 *
 * Module configuration are in $Modules. Module pages which include
 * this file should first set its module index as $View.
 *
 * Restarts the session for live page reload rate.
 */
require_once('../lib/vars.php');

$Reload= TRUE;
SetRefreshInterval();

$View->Controller($Output, 'GetDefaultLogFile');
$LogFile= $Output[0];

UpdateLogsPageSessionVars($LinesPerPage, $SearchRegExp);

$View->Controller($Output, 'GetFileLineCount', $LogFile, $SearchRegExp);
$LogSize= $Output[0];

require_once($VIEW_PATH.'/header.php');
		
PrintLiveLogHeaderForm();
?>
<table id="logline">
	<?php
	PrintTableHeaders($View->Model);

	$View->Controller($Logs, 'GetLiveLogs', $LogFile, $LinesPerPage, $SearchRegExp);
	$Logs= unserialize($Logs[0]);

	$LineCount= 1;
	if ($LogSize > $LinesPerPage ) {
		$LineCount= $LogSize - $LinesPerPage + 1;
	}

	foreach ($Logs as $Logline) {
		$View->PrintLogLine($Logline, $LineCount++);
	}
	?>
</table>
<?php
PrintHelpWindow($View->LogsHelpMsg);
require_once($VIEW_PATH.'/footer.php');
?>