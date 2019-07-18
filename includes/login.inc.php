<?php

session_start();

if (isset($_POST['submit'])) {
	
	include 'dbh.inc.php';

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//Error handling
	//checking if inputs are empty

	if (empty($username) || empty($pwd)) {
		header("Location: ../index.php?login=emty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE user_name = '$username' OR user_email = '$username'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../index.php?login=error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//de-hashing the password

				$hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
				if ($hashedPwdCheck == false) {
					header("Location: ../index.php?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//login the user
					//starting SESSION

					$_SESSION['username'] = $row['user_name'];
					$_SESSION['first'] = $row['user_first'];
					$_SESSION['last'] = $row['user_last'];
					$_SESSION['email'] = $row['user_email'];
					$_SESSION['pwd'] = $row['user_pwd'];

					header("Location: ../index.php?login=success");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index.php?login=error");
	exit();
}