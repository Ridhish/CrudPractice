<?php
if(isset($_POST) && !empty($_POST)){
	$full_name = (isset($_POST['full_name']))?$_POST['full_name']:'';
	$first_name = (isset($_POST['first_name']))?$_POST['first_name']:'';
	$middle_name = (isset($_POST['middle_name']))?$_POST['middle_name']:'';
	$last_name = (isset($_POST['last_name']))?$_POST['last_name']:'';
	$email = (isset($_POST['email']))?$_POST['email']:'';
	$subject = (isset($_POST['subject']))?$_POST['subject']:'';
	$message = (isset($_POST['message']))?$_POST['message']:'';
	$contact_no = (isset($_POST['contact_no']))?$_POST['contact_no']:'';
	$class_type = (isset($_POST['class_type']))?$_POST['class_type']:'';
	
	if($full_name == ''){
		$full_name =  $first_name.' '.$middle_name.' '.$last_name;
	}
	
	$sendMessage = $mailSubject = '';
	if($_POST['form_type'] == 'contact'){
		$mailSubject = 'Contact Details';
		$sendMessage = "<p>Hello,</p><p><b>".$full_name."</b> has sent a message having </p><p><b>Subject:</b> ".$subject."</p><p><b>Email id:</b> ".$email."</p><p><b>Query is:</b> ".$message."</p>";
	}elseif($_POST['form_type'] == 'inquiry'){
		$mailSubject = 'Inquiry Details';
		$sendMessage = "<p>Hello,</p><p><b>".$full_name."</b> has sent a message having </p><p><b>Class Type:</b> ".$class_type."</p><p><b>Email id:</b> ".$email."</p><p><b>Contact No. is:</b> ".$contact_no."</p>";
	}
	
	if($sendMessage != ''){
		$fromEmail = 'support@fitnessfirst.com';
		$toEmail = 'shubham.choudhary@himanshusofttech.com';
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: <$fromEmail>" . "\r\n";

		if(mail($toEmail , $mailSubject , $sendMessage , $headers )){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
}else{
	echo 0;
}

?>