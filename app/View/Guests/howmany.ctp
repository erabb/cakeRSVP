<h2>How Many Guests in The Party?</h2>

<?php $nums = array(1 => 1,2 => 2,3 => 3,4 => 4,5 => 5); 
	echo $this->Form->create('Howmany');
	echo $this->Form->select('howmany', $nums);
	echo $this->Form->end(__('Submit')); 
?>
