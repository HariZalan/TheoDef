<?php
session_start();
?>
<!DOCTPYE html>
<html>
<head>
<meta charset="utf-8" />        
</head>
<body>
<form action="./reports.php" method="post">
    <textarea name="report"></textarea>
    <input type="submit" value="Beküldés" />
</form>
<?php
include("reports.inc");
include("emailAddressesandUsernames.php");
if($_POST["report"]) {
if ($_SESSION["email"]) {
$author = $_USERNAME[$_SESSION["email"]];
$file = fopen("reports.inc", "a");
fwrite($file,"Szerző: ".$author."<br/> Dátum: ".date("Y. m. d., h:i:s")."<br/><br/>". $_POST["report"]."<hr/>");
fclose($file);
$_POST["report"] = "";
} else {
    die("Be kell jelentkezned.");
}
};
?>
</body>
</html>