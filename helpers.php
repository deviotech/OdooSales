<?php  

function base_url($uri = ''){
	return sprintf(
	    "%s://localhost/odoosales/",
	    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
	    $uri !== '' ? "$uri" : ''
  	);
}

function session($key)
{
	if(is_array($key))
	{
		foreach($key as $k => $v)
			$_SESSION[$k] = $v;

		return true;
	}
	return !empty($_SESSION[$key]) ? $_SESSION[$key] : '';
}

function auth_check()
{
	return !empty(session('username'));
}

function login($username, $password)
{
	$uname = 'info@medco.ie';
	$upassword = 'Lismore';

	if($uname == $username && $upassword == $password)
	{
		session(['username' => $uname]);
		return true;
	}
	return false;
}

function logout()
{
	session(['username' => '']);
	session_destroy();
}
?>