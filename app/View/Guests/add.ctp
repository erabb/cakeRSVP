<!-- app/View/Users/add.ctp -->
<div class="guest form">
<?php echo $this->Form->create('Guest'); ?>
<legend><?php echo __('Add Guest'); ?></legend>
<div class="input email"><label for="0GuestEmail">Email</label><input name="data[0][Guest][email]" maxlength="50" type="email" value="holly@test.com" id="0GuestEmail"/></div>
<?php
$num = 0;
while ($num < $numberInParty ){
	echo $this->Form->input('Guest.'. $num . '.email');
    echo $this->Form->input('Guest.' . $num . '.first_name', array('label' => 'Your name here'));
    echo $this->Form->input('Guest.' . $num . '.last_name');
    echo $this->Form->hidden('Guest.' . $num. '.user_id', array('value' => $user_id) );
    echo '<div class="input radio">';
    echo $this->Form->radio('Guest.' . $num . '.allow_plus1', array( 1 => 'Yes', 0 => 'No'), array('legend' => 'Allow guest a plus one?'));
   	echo '</div>';
   /* if(isset($question1)){
    	echo '<div class="input select">';
    	echo $this->Form->label('Guest.' . $num . '.question1', 'Choose your meal option');
    	echo $this->Form->select('Guest.' . $num . '.question2', $question1, array('empty' => 'Please choose one?', ));
    	echo '</div>';
    }*/
$num++;
}
?>

<?php
echo $this->Form->end(__('Submit')); ?>
</div>
