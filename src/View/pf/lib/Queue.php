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

namespace View;

class Queue extends Rule
{
	function display($ruleNumber, $count)
	{
		$this->dispHead($ruleNumber);
		$this->dispValue('name', _TITLE('Name'));
		$this->dispInterface();
		$this->dispValue('parent', _TITLE('Parent'));
		$this->dispBandwidth('bandwidth', 'bw', _TITLE('Bandwidth'), 3);
		$this->dispBandwidth('min', 'min', _TITLE('Min'), 2);
		$this->dispBandwidth('max', 'max', _TITLE('Max'), 2);
		$this->dispValue('qlimit', _TITLE('Qlimit'));
		$this->dispKey('default', _TITLE('Default'));
		$this->dispTail($ruleNumber, $count);
	}
	
	function dispBandwidth($key, $pre, $title, $colspan)
	{
		?>
		<td title="<?php echo $title; ?>" colspan="<?php echo $colspan; ?>">
			<?php echo $this->rule[$key] . ($this->rule["$pre-burst"] ? '<br>burst: ' . $this->rule["$pre-burst"] : '') . ($this->rule["$pre-time"] ? '<br>time: ' . $this->rule["$pre-time"] : ''); ?>
		</td>
		<?php
	}

	function input()
	{
		$this->inputKey('name');
		$this->inputKey('interface');
		$this->inputKey('parent');
		$this->inputKey('bandwidth');
		$this->inputKey('bw-burst');
		$this->inputKey('bw-time');
		$this->inputKey('min');
		$this->inputKey('min-burst');
		$this->inputKey('min-time');
		$this->inputKey('max');
		$this->inputKey('max-burst');
		$this->inputKey('max-time');
		$this->inputKey('qlimit');
		$this->inputBool('default');

		$this->inputKey('comment');
		$this->inputDelEmpty();
	}

	function edit($ruleNumber, $modified, $testResult, $generateResult, $action)
	{
		$this->editIndex= 0;
		$this->ruleNumber= $ruleNumber;

		$this->editHead($modified);

		$this->editText('name', _TITLE('Name'), FALSE, NULL, _CONTROL('string'));
		$this->editText('interface', _TITLE('Interface'), 'queue-interface', 10, _CONTROL('if or macro'));
		$this->editText('parent', _TITLE('Parent'), NULL, NULL, _CONTROL('string'));
		$this->editBandwidth('bandwidth', 'bw', _TITLE('Bandwidth'));
		$this->editBandwidth('min', 'min', _TITLE('Min'));
		$this->editBandwidth('max', 'max', _TITLE('Max'));
		$this->editText('qlimit', _TITLE('Qlimit'), NULL, NULL, _CONTROL('number'));
		$this->editCheckbox('default', _TITLE('Default'));

		$this->editComment();
		$this->editTail($modified, $testResult, $generateResult, $action);
	}

	function editBandwidth($key, $pre, $title)
	{
		?>
		<tr class="<?php echo ($this->editIndex++ % 2 ? 'evenline' : 'oddline'); ?>">
			<td class="title">
				<?php echo _TITLE($title).':' ?>
			</td>
			<td>
				<table style="width: auto;">
					<tr>
						<td class="ifs">
							<input type="text" id="<?php echo $key ?>" name="<?php echo $key ?>" size="15" value="<?php echo $this->rule[$key]; ?>" placeholder="<?php echo _CONTROL('number[(K|M|G)]') ?>" />
						</td>
						<td class="optitle"><?php echo $key ?><?php $this->editHelp('bandwidth') ?></td>
					</tr>
					<tr>
						<td class="ifs">
							<input type="text" id="<?php echo $pre ?>-burst" name="<?php echo $pre ?>-burst" size="15" value="<?php echo $this->rule["$pre-burst"]; ?>"
								   placeholder="<?php echo _CONTROL('number[(K|M|G)]') ?>" <?php echo isset($this->rule[$key]) ? '' : 'disabled'; ?> />
						</td>
						<td class="optitle">burst</td>
					</tr>
					<tr>
						<td class="ifs">
							<input type="text" id="<?php echo $pre ?>-time" name="<?php echo $pre ?>-time" size="15" value="<?php echo $this->rule["$pre-time"]; ?>"
								   placeholder="<?php echo _CONTROL('number(ms)') ?>" <?php echo isset($this->rule[$key]) ? '' : 'disabled'; ?> />
						</td>
						<td class="optitle">time</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php
	}
}
?>