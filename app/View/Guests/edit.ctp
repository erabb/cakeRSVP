<!-- app/View/Users/edit.ctp -->
<div class="guest form">
<?php echo $this->Form->create('Guest'); ?>
<legend><?php echo __('Edit Guest'); ?></legend>

<?php
//Debugger::dump($guests);
$i = 0;
while ($i <= $num ){
	echo $this->Form->input($i .'.Guest.email');
	echo $this->Form->input($i .'.Guest.first_name', array('label' => 'Your name here'));
    echo $this->Form->input($i . '.Guest.last_name');
    echo $this->Form->input($i . '.Guest.id', array('type' => 'hidden'));
   	echo '<div class="input radio">';
    echo $this->Form->radio($i .'.Guest.allow_plus1', array( 1 => 'Yes', 0 => 'No'), array('legend' => 'Allow guest a plus one?'));
   	echo '</div>';

   /* if(isset($question1)){
    	echo '<div class="input select">';
    	echo $this->Form->label('Guest.' . $num . '.question1', 'Choose your meal option');
    	echo $this->Form->select('Guest.' . $num . '.question2', $question1, array('empty' => 'Please choose one?', ));
    	echo '</div>';
    }*/

    $i++;
}


echo $this->Form->end(__('Submit')); ?>
$this->Html->link(__('Edit'), array('action' => 'edit', $guest['Guest']['family_group'],$guest['Guest']['user_id'] ));
</div>
