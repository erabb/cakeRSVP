<?php
//app/Model/User.php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel{
	public $validate = array(
		'email' => array(
			'email_format' => array(
        		'rule'    => array('email'),
        		'message' => 'Please supply a valid email address.'
        		),
        	'unique' => array(
        		'rule'    => 'isUnique',
        		'message' => 'This email has already been registered.'	
        		)
    		),
    	
    	'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
                 )
           ), 
            
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'bride')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
              )
       		),
       		
       	'first_name' => array(
       		'length' => array(
       			'rule' => array('maxLength', 50)
       			)
       		),
       		
       	'last_name' => array(
       		'length' => array(
       			'rule' => array('maxLength', 50)
       			)
       		)		
		
	);	
	
	public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
        $passwordHasher = new BlowfishPasswordHasher();
        $this->data[$this->alias]['password'] = $passwordHasher->hash(
            $this->data[$this->alias]['password']
        );
    }
    return true;
	}
	
	public $hasMany = array(
		'Guest' => array(
			'className' => 'Guest'
			)
		
	);

}
?>