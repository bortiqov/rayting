<?php
	date_default_timezone_set("Asia/Samarkand");

	require ("../config.php");
	require ("service.class.php");
	require ("ProviderWebService.class.php");
	//die(phpinfo());
	// OPISANIE FUNCTSII MAIL
	function smtpSend ($to, $subject, $html, $text='', $from='noreply@webname.uz', $files=array())  {
		return;
		global $config;
		require_once "Mail.php"; // PEAR Mail package
		require_once ('Mail/mime.php'); // PEAR Mail_Mime packge
		if (!$text) $text=strip_tags($html);
		$headers = array ('From' =>"izzatraxmatov41@gmail.uz",'Reply-to'=>$from, 'Return-Path'=>$from, 'To' => $to, 'Subject' =>$subject);
		$crlf = "\n";
		$mime = new Mail_mime($crlf);
		$mime->_build_params['head_charset']='UTF-8';
		$mime->_build_params['html_charset']='UTF-8';
		$mime->_build_params['text_charset']='UTF-8';
		$mime->setTXTBody($text);
		$mime->setHTMLBody($html);
		foreach ($files as $file) {
			$mime->addAttachment($file, "Application/octet-stream",$file, 1);
		}
		$body = $mime->get(array('text_charset' => 'utf-8'));
		$headers = $mime->headers($headers);
		$host = "mail.gmail.com";
		$username = "izzatraxmatov41@gmail.com";
		$password = "Abkrf101ROOT";//.47
		$smtp = Mail::factory('smtp', array ('host' => $host,'auth' => true, 'port'=>25,
				'username' =>$username,'password' => $password, 'debug'=>false));
		$mail = $smtp->send($to, $headers, $body);
		if (PEAR::isError($mail)) {
			return $mail->getMessage();
		}
	};
	// ***************************************************************************************
	$log5=print_r($GLOBALS, true);
	$log5='<pre>'.$log5.'</pre>';
	//smtpSend("izzatraxmatov41@gmail.com", "PAYNET vhod", $log5, "test");
	
	ini_set("soap.wsdl_cashe_enabled","1");
	$server=new SoapServer("https://api.job-cafe.uz/payment/paynet/ProviderWebService.wsdl", array('soap_version' => SOAP_1_1, 'cache_wsdl' => WSDL_CACHE_NONE));
	$server->setClass("ProviderWebService");
	$server->handle();
?>
