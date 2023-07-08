<?php
session_start();
if (isset($_POST["code"])) {
	if (md5($_POST["code"]) == $_COOKIE['code']) {
		$_SESSION['email'] = $_SESSION["unconfirmedEmail"];
		setcookie('code', $_COOKIE["code"], time() + 1, "/");
		$_SESSION['unconfirmedEmail']= "";
		echo ('Rendben. Beléptél.');
		include("emailAddressesandUsernames.php");
		if ($_USERNAME[$_SESSION["email"]]) {
		header ("Location: /hu/TheoDef/index.php");
		} else {
		  header("Location: /hu/TheoDef/registration.php");  
		};
		
		} else {
		    echo ('A kód hibás.');
		};

	} else {
	    $code = rand(10000, 99999);
	    $cookieemail = $_SESSION["unconfirmedEmail"];
	    echo($cookieemail . "<p />");
        mail($cookieemail, 'Ellenőrző kód', 'Az ellenőrző kód ' . $code, 'From: server@elektropress.hu');
        setcookie("code", md5($code), time() + 31536000, "/");
	};
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Ellenőrző kód megadása</title>
</head>

<body>
<form action="logIn.php" method="post">
<legend>E-mail-ben elküldtük az ellenőrző kódot. Itt add meg:</legend>
<p></p>
<input type="password" placeholder="Ellenőrző kód" name="code" />
<input type="submit" value="Kész" />
</form>
</body>
</html>