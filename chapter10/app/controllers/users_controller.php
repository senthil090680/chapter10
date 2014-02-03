<?php
class UsersController extends AppController {
	var $name		=	'Users';
	//var $scaffold;
	function signup() {
		if(!empty($this->data)) {
			if(isset($this->data['User']['password2'])) {
				$this->data['User']['password2hashed']	=	$this->Auth->password($this->data['User']['password2']);
				$this->data['User']['confirm_code'] = String::uuid();
				$this->User->create();
				if($this->User->save($this->data)) {
					$this->Email->to					=	$this->data[User][email];
					$this->Email->subject				=	"Quickwall Confirmation";
					$this->Email->replyTo				=	'noreply@hrbestpick.com';
					$this->Email->from					=	'Quickwall <noreply@hrbestpick.com>';
					$this->Email->sendAs				=	'html';
					$this->Email->template				=	'confirmation';

					$this->set('name',$this->data[User][username]);
					$this->set('server_name',$_SERVER[SERVER_NAME]);
					$this->set('id',$this->User->getLastInsertID());
					$this->set('code',$this->data[User][confirm_code]);

					if($this->Email->send()) {
						$this->Session->setFlash('Congratulations! You have signed up!');
						$this->redirect(array('controller'=>'questions','action'=>'home'));
					} else {
						$this->User->del($this->User->getLastInsertID());
						$this->Session->setFlash('There was a problem sending the confirmation mail. Please try again');
					}
				} else {
					$this->Session->setFlash('There was an error signing up.  Please try again.');
					$this->data		=	null;
				}
			}
		}
	}
	function login() {	
	}
	function logout () {
			$this->Session->setFlash('Logout');
			$this->redirect($this->Auth->logout());
	}
	function confirm($user_id = null, $code=null) {
		if(empty($user_id) || empty($code)) {
			$this->set('confirmed',0);
			$this->render();
		}
		$user	=	$this->User->read(null,$user_id);
		if(empty($user)) {
			$this->set('confirmed',0);
			$this->render();
		}
		if($user[User][confirm_code] == $code) {
			$this->User->id		=	$user_id;
			$this->User->saveField('confirmed','1');
			$this->set('confirmed',1);
		} else { 
			$this->set('confirmed',0);
		}


	}
}
?>