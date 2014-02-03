<?php
class AppController extends Controller {
	var $components		=		array('Auth','Email');
	function beforeFilter() {
		$this->Auth->loginRedirect	=	array('controller'=>'questions','action'=>'home');
		$this->Auth->logoutRedirect	=	array('controller'=>'questions','action'=>'home');
		$this->Auth->allow('signup','confirm','home','show');
		$this->Auth->authorize		=	'controller';
		$this->Auth->userScope		=	array('User.confirmed'=>'1');
		$this->set('loggedIn',$this->Auth->user('id'));
	}
	function isAuthorized() {
		return true;
	}
}
?>