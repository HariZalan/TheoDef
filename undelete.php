<?php
session_start();
if ($_GET["gnum"]) {
    $gnum = $_GET["gnum"];
    $whoCanDelete=file_get_contents("whoCanDelete.php");
    if (str_replace(" ".$_SESSION["email"],"",$whoCanDelete)!=$whoCanDelete) {
        $data = file_get_contents("./deleted/$gnum");
        $file = fopen("./theorems/$gnum.xml","a");
        fwrite($file,str_replace("Helyreállítva","",str_replace("Törölve.","",$data)));
        fclose($file);
        $file = fopen("./deleted/$gnum", "w");
        fwrite ($file, "Helyreállítva.");
        fclose ($file);
        echo ("A helyreállítás megtörtént.");
    } else {
        die ("Nincs jogod a helyreállításhoz. Igényelni <a href=\"./reports.php\">itt</a> tudod.");
    }
};
?>