<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<form action="preLogIn.php" method="post">
<input type="email" placeholder="E-mail-címed" name="email" />
<input type="submit" value="Ellenőrzés" />
</form>
</body>
</html>
<?php
if (isset ($_POST["email"])) {
$_SESSION["unconfirmedEmail"] = $_POST["email"];
header ("Location: /hu/TheoDef/logIn.php");
};
?>
