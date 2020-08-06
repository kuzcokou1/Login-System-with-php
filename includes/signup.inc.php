<?php

if (isset($_POST['submit'])){
	
	include 'dbh.inc.php';

	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	//Error Handling
	//Checking for empty fields

	if (empty($first) || empty($last) || empty($username) || empty($email) || empty($pwd)) {
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {

		//Checking if input characters are valid

		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {
			//checking if email is valid

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				header("Location: ../signup.php?signup=invalidemail");
				exit();
			} else {
				$sql = "SELECT * FROM users WHERE user_name='$username";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				if ($resultCheck > 0) {
					header("Location: ../signup.php?signup=userexists");
					exit();
				} else {
					//hashing the password

					$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

					//insert the user into the database

					$sql = "INSERT INTO users (user_first, user_last, user_name, user_email,user_pwd) VALUES ('$first', '$last', '$username', '$email', '$hashedPwd');";
					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();
				}				
			}
		}
	}

} else {
	header("Location: ../signup.php");
	exit();
}
