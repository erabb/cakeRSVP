<?php
//app/Model/Guest.php
App::uses('AppModel', 'Model');

class Guest extends AppModel {
  public $actsAs = array('Containable');
  
	public $validate = array(
		'email' => array(
			'email_format' => array(
				'allowEmpty'=> true,
        		'rule'    => array('email'),
        		'message' => 'Please supply a valid email address.'
        		),
        	'unique' => array(
        		'allowEmpty'=> true,
        		'rule'    => 'isUnique',
        		'message' => 'This email has already been registered.'	
        		)
    		),
    	'first_name' => array(
       		'length' => array(
       			'rule' => array('maxLength', 50),
       			'required' => true,
       			'message' => 'A first name is required'
       			)
       		),
       		
       	'last_name' => array(
       		'length' => array(
       			'rule' => array('maxLength', 50),
       			'required' => true,
       			'message' => 'A last name is required'
       			)
       		),
       	'initial' => array(
       		'length' => array(
       			'rule' => array('maxLength' , 1)
       			),
       		'pattern'=>array(
                 'rule'      => '/^[a-z]+/i',
                	'message'   => 'Only letters allowed',
            	),	
       		),
       	'acceptance' => array(
       		'trueorfalse' => array(
       			'rule' => array('boolean')
       			)
       		),
       	'guest_created' => array(
       		'trueorfalse2' => array(
       			'rule' => array('boolean')
       			)
       		)					
		
	);	
	
	public $belongsTo = 'User';
	
}
?>