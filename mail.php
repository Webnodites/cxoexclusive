<?php

if(isset($_POST["submit"]))
{
    $fname=$_POST["firstname"];
	$lname=$_POST["lastname"];
	$country=$_POST["country"];
	$email=$_POST["txtEmail"];
	$phone=$_POST["txtMobile"];
	$profile=$_POST["profile"];
	$company=$_POST["company"];
	$industry=$_POST["industry"];
	$interest=$_POST["interest"];
	$msg=$_POST["message"];
	$type=$_POST["radiobtn"];
	
	$from = $fname." ".$lname;
	$to = "contact@tesventures.in";

	$sub = "Enquiry Form";

	$header = "From:".$from."<".$email.">\n";
	
	$message = "First Name: ".$fname."\n";
	$message .= "Last Name: ".$lname."\n";
	$message .= "Country: ".$country."\n";
	$message .= "Email: ".$email."\n";
	$message .= "Mobile No.: ".$phone."\n";
	$message .= "Profile: ".$profile."\n";
	$message .= "Company: ".$company."\n";
	$message .= "Industry: ".$industry."\n";
	$message .= "Area Of Interest: ".$interest."\n";
	$message .= "Type: ".$type."\n";
	$message .= "Message: ".$msg."\n";
	
	
    
    if (isset($_FILES) && (bool) $_FILES) {

    $allowedExtensions = array("pdf", "doc", "docx", "gif", "jpeg", "jpg", "png");

    $files = array();
    foreach ($_FILES as $name => $file) {
        $file_name = $file['name'];
        $temp_name = $file['tmp_name'];
        $file_type = $file['type'];
        $path_parts = pathinfo($file_name);
        $ext = $path_parts['extension'];
        if (!in_array($ext, $allowedExtensions)) {
            echo "<script>alert('Attach A valid Image file!');
			   </script>";
            die("File $file_name has the extensions $ext which is not allowed");
        }
        array_push($files, $file);
    }

    // boundary 
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // headers for attachment 
    $header .= "MIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // multipart boundary 
    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
    $message .= "--{$mime_boundary}\n";

    // preparing attachments
    for ($x = 0; $x < count($files); $x++) {
        $file = fopen($files[$x]['tmp_name'], "rb");
        $data = fread($file, filesize($files[$x]['tmp_name']));
        fclose($file);
        $data = chunk_split(base64_encode($data));
        $name = $files[$x]['name'];
        $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" .
                "Content-Disposition: attachment;\n" . " filename=\"$name\"\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        $message .= "--{$mime_boundary}\n";
        
     
    }
  
    }
    
    
	$sendmail = mail($to, $sub, $message, $header);

	
	if($sendmail){
		echo "<script>alert('Message Sent Successfully!');window.location.href='index'
			   </script>";
	}
	else{
	
		echo "<script>
			alert('Something Went Wrong!');window.location.href='register';  
			</script>";

		}

}


?>
