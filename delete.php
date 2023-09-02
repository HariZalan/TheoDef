<?php
if (!$_COOKIE["email"]) {
    die("Be kell jelentkezned.");
}
include("emailAddressesandUsernames.php");
if ($_GET["gnum"]) {
    $gnum = $_GET["gnum"];
    $whoCanDelete=file_get_contents("whoCanDelete.php");
    if (str_replace(" ".$_COOKIE["email"],"",$whoCanDelete)!=$whoCanDelete) {
        $data = file_get_contents("./theorems/$gnum.xml");
        unlink("./theorems/$gnum.xml");
        $file = fopen("./deleted/$gnum", "a");
        fwrite ($file, "A korábbi tartalom XML-ben: „".$data."” – a lapot ".$_USERNAME[$_COOKIE["email"]]." törölte ".date("Y. m. d., h:i:sa")."-kor");
        fclose ($file);
        include("./emailAddressesandUsernames.php");
        $username = $_USERNAME[$_COOKIE["email"]];
        echo ("Törölve.");
    } else {
        die ("Nincs jogod a törléshez. Igényelni <a href=\"./reports.php\">itt</a> tudod.");
    }
};
?>