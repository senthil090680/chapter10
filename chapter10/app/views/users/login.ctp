<h2>Log In To Quickwall</h2>
<?php
if ($session->check('Message.auth')):
$session->flash('auth');
endif;
?>
<?php e($form->create('User', array('action' => 'login')));?>
<fieldset>
<label for="UserUsername" class="usernamelabel"><span>
Your Name</span></label>
<?php e($form->text('username', array('class'
=> 'fullwidth'))); ?>
<label for="UserPassword" class="emaillabel"><span>Password
</span></label>
<?php e($form->password('password', array('class'
=> 'fullwidth'))); ?>
<?php e($form->submit('Login In', array('div' => false,
'class' => 'submitbutton'))); ?>
</fieldset>
<?php e($form->end()); ?>