<?php
session_start();
if ($_GET["gnum"]) {
    $gnum = $_GET["gnum"];
    $whoCanDelete=file_get_contents("whoCanDelete.php");
    if (str_replace(" ".$_SESSION["email"],"",$whoCanDelete)!=$whoCanDelete) {
        $data = file_get_contents("./theorems/$gnum.xml");
        $file = fopen("./theorems/$gnum.xml","w");
        fwrite($file,"Törölve.");
        fclose($file);
        $file = fopen("./deleted/$gnum", "a");
        fwrite ($file, $data);
        fclose ($file);
        include("./emailAddressesandUsernames.php");
        $username = $_USERNAME[$_SESSION["email"]];
        echo ("$username törölte ".date("Y. m. d., H:i:s")."-kor.");
    } else {
        die ("Nincs jogod a törléshez. Igényelni <a href=\"./reports.php\">itt</a> tudod.");
    }
};
?>