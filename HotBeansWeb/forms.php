<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
function generateBoundary() {
    return "===" . md5(uniqid(mt_rand(), true)) . "===";
}
$_allowed_file_extension = ['png', 'doc'];
$allowed_mime_type = ['image/png', 'application/msword'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['formContact'])) {
    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $email = $_POST["email"];
    $content = $_POST["message"];
    $to = "AustinATTS@Engineer.Com";
    $subject = "Contact Form Submission";
    $boundary = generateBoundary();
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";	
    $message .= "
    			<!DOCTYPE html>
					<html>
						<body style='background-color: #CCCCCC; padding-left: 20%; padding-top: 2.5%;'>
							<div style='display: flex; backgroun-color #333333'>
								<a href='https://www.austinatts.co.uk/Projects/HotBeansWeb'>
									<img src='https://www.austinatts.co.uk/Projects/HotBeansWeb/assets/general/logo.png' alt='Company Logo' style='max-width: 200px;'>
								</a>
								<h1 style='font-family:Selawik; color: #F76000; padding-left: 2.5%;'>
									Job Application Form Submission
 								</h1>
							</div>
							<p style='padding-left: 5%; padding-top: 2.5%;'>
								<strong>
									First Name:
 								</strong>
 								$first_name
 									<br>
									<br>
	 							<strong>
	 								Last Name:
	  							</strong>
	  							$last_name
	   								<br>
									<br>
	 							<strong>
	 								Email:
	  							</strong>
	  							$email
  									<br>
									<br>
	 							<strong>
	 								Message:
	  							</strong>
	  							$content
	  								<br>
							</p>
						</body>
					</html>";
	$message .= "</body></html>\r\n";
    $message .= "--$boundary--";
    $mail_success = mail($to, $subject, $message, $headers);
    if (!$mail_success) {
        echo "Error sending email. Details: " . print_r(error_get_last(), true);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['formApply'])) {
    $first_name = $_POST['First_Name'];
    $last_name = $_POST['Last_Name'];
    $email = $_POST['Email_Address'];
    $position = $_POST['Position'];
    $salary = $_POST['Salary'];
    $start_date = $_POST['StartDate'];
    $phone = $_POST['Phone'];
    $country = $_POST['country'];
    $relocate = $_POST['Relocate'];
    $organization = $_POST['Organization'];
    $reference = $_POST['Reference'];
    $file_name = $_FILES['myfile']['name'];
    $file_temp = $_FILES['myfile']['tmp_name'];
    $file_size = $_FILES['myfile']['size'];
    $file_type = $_FILES['myfile']['type'];
    if ($file_name !== "") {
        $upload_path = "uploads/";
        $file_destination = $upload_path . uniqid() . "_" . $file_name;
        move_uploaded_file($file_temp, $file_destination);
    }
    $to = "AustinATTS@Engineer.Com";
    $subject = "Job Application Form Submission";
    $boundary = generateBoundary();
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message .= "
    			<!DOCTYPE html>
					<html>
						<body style='background-color: #CCCCCC; padding-left: 20%; padding-top: 2.5%;'>
							<div style='display: flex; backgroun-color #333333'>
								<a href='https://www.austinatts.co.uk/Projects/HotBeansWeb'>
									<img src='https://www.austinatts.co.uk/Projects/HotBeansWeb/assets/general/logo.png' alt='Company Logo' style='max-width: 200px;'>
								</a>
								<h1 style='font-family: Selawik; color: #F76000; padding-left: 2.5%;'>
									Job Application Form Submission
								</h1>
							</div>
							<p style='padding-left: 5%; padding-top: 2.5%;'>
								<strong>
									First Name:
	 							</strong>
 								$first_name
 									<br>
									<br>
								<strong>
									Last Name:
	 							</strong>
	 							$last_name
	 								<br>
									<br>
								<strong>
									Email:
	 							</strong>
	 							$email
	  								<br>
									<br>
								<strong>
									Position:
	 							</strong>
	 							$position
	 								<br>
									<br>
								<strong>
									Salary:
	 							</strong>
	 							$salary
	 								<br>
									<br>
								<strong>
									Start Date:
	 							</strong>
	 							$start_date
	 								<br>
									<br>
								<strong>
									Phone:
	 							</strong>
	 								$phone
	  								<br>
									<br>
								<strong>
									Country:
	 							</strong>
	 							$country
	 								<br>
									<br>
								<strong>
									Willing to Relocate:
	 							</strong> $relocate
	 								<br>
									<br>
								<strong>
									Last Company Worked For:
	 							</strong>
	 							$organization
	 								<br>
									<br>
								<strong>
									Reference/Comments/Questions:
	 							</strong>
	 								<br>
	  								<br>
	   							$reference
							</p>
						</body>
					</html>";
    if ($file_name !== "") {
        $file_contents = file_get_contents($file_destination);
        $file_encoded = chunk_split(base64_encode($file_contents));
        $message .= "\r\n\r\n--$boundary\r\n";
        $message .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $message .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message .= $file_encoded . "\r\n";
    }
    $message .= "</body></html>\r\n";
    $message .= "--$boundary--";
    $mail_success = mail($to, $subject, $message, $headers);
    if (!$mail_success) {
        echo "Error sending email. Details: " . print_r(error_get_last(), true);
    }
    if ($file_name !== "") {
        unlink($file_destination);
    }
}
?>
