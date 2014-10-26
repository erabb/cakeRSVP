
<div class="guest index">
<h2>Hi <?php 
	echo ($guests[0]['User']['first_name']) ?>,</h2>
<h3>Dashboard Totals</h2>

<table>
<tr>
<td>
	<b>Number of Guests:</b>
</td>
<td>
	<?php echo $guestTotal; ?>
</td>
</tr>

<tr>
	<td>
		<b>Number of Yes:</b>
	</td>
	<td>
		<?php echo $yesTotal; ?>
	</td>
</tr>

</table>

<!-- guest list -->

<table cellpadding="0" cellspacing="0">
		<?php echo $this->Html->tableHeaders(array(
			$this->Paginator->sort('first_name'),
			$this->Paginator->sort('last_name'),
			__('Email'),
			__('Created'),
			$this->Paginator->sort('family_group'),
			$this->Paginator->sort('acceptance'),
			__('Actions'),
		));
		
		//Table Content.
		$rows = array();
		$familyClass = "";
		$green = false;
		foreach ($guests as $guest){	
			$row = array();
			//First name.
			$row[] = h($guest['Guest']['first_name']);
			//Last name
			$row[] = h($guest['Guest']['last_name']);
			//Email
			$row[] = h($guest['Guest']['email']);
			//Created
			$row[] = h($guest['Guest']['created']);
			//Family Group
			$row[] = h($guest['Guest']['family_group']);
			//Accepted
			if($guest['Guest']['acceptance']){
				$accept = 'Yes';
			} else{
				$accept = 'No';
			}
			$row[] = h($accept);
				
		
			//Actions.
			$actions = array();
			$actions[] = $this->Html->link(__('Edit'), array('action' => 'edit', $guest['Guest']['family_group'],$guest['Guest']['user_id'] ));
			$actions[] = $this->Form->postLink(__('Delete'), array('action' => 'delete', $guest['Guest']['id']), null, __('Are you sure you want to delete # %s?', $guest['Guest']['id']));
			
			

			
			
			
			// check to see if this is a new family group
			if($guest['Guest']['family_group'] == $familyClass){
				$row[] = array(
				implode(' ', $actions),
				array('class' => 'actions'),
				);
				//if family_group the same give the same background
				if($green){
					echo $this->Html->tableCells($row, array('class' => 'greenBckgd'), false, false, true);
				}else{
					echo $this->Html->tableCells($row);
					}
			}else{ //if a new family group give a new background
				$actions[] = $this->Html->link(__('Add to party'), array('action' => 'addToParty', $guest['Guest']['family_group'],$guest['Guest']['user_id'] ));
				$row[] = array(
				implode(' ', $actions),
				array('class' => 'actions'),
				);
				if($green){
					$green = false;
					echo $this->Html->tableCells($row);
				}else{
					$green = true;
					echo $this->Html->tableCells($row, array('class' => 'greenBckgd'), false, false, true);
					}
			}
			
			//set the family class so that it can be checked against in the next loop	
			$familyClass = $guest['Guest']['family_group'];
			

				
		}

		?>

	
	</table>
		<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Guest'), array('action' => 'add')); ?></li>
	</ul>
</div>
	