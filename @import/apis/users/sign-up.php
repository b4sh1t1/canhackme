<?php
	if(!isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['comment'])){
		$res = ['result' => 'error'];
		goto tail;
	}

	if(is_use_recaptcha()){
		if(!isset($_POST['recaptcha-token']) || !is_valid_recaptcha_token($_POST['recaptcha-token'])){
			$res = ['result' => 'invalid_token'];
			goto tail;
		}
	}

	if(Users::is_signed()){
		$res = ['result' => 'already_signed'];
		goto tail;
	}

	if(!Users::is_valid_user_name($_POST['name'])){
		$res = ['result' => 'invalid_name'];
		goto tail;
	}

	if(Users::is_exists_user_name($_POST['name'])){
		$res = ['result' => 'already_exists_name'];
		goto tail;
	}

	if(!Users::is_valid_user_email($_POST['email'])){
		$res = ['result' => 'invalid_email'];
		goto tail;
	}

	if(Users::is_exists_user_email($_POST['email'])){
		$res = ['result' => 'already_exists_email'];
		goto tail;
	}

	if(!Users::is_valid_user_password($_POST['password'])){
		$res = ['result' => 'invalid_password'];
		goto tail;
	}

	if(!Users::is_valid_user_comment($_POST['comment'])){
		$res = ['result' => 'invalid_comment'];
		goto tail;
	}

	if(!Users::do_sign_up($_POST['name'], $_POST['email'], $_POST['password'], $_POST['comment'])){
		$res = ['result' => 'error'];
		goto tail;
	}

	$res = ['result' => 'valid'];

	tail:
	Templater::json($res);
