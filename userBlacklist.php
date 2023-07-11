<?php
$filecontent=file_get_contents("userBlacklist.inc.php");
if (str_replace(" ".$_SESSION["email"]." ","",$filecontent)!=$filecontent) {
    die("Nem tudsz szerkeszteni, mivel feketelistán vagy. Ennek okáról, annak közlése hiányában, <a href='reports.php'>itt</a> tudsz érdeklődni.");
};
?>