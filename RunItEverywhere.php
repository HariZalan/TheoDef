<?php
if ($_COOKIE["email"]) {
    if(str_replace('$_USERID["'.$_COOKIE["email"].'"]',"",file_get_contents("user_IDs.php"))==file_get_contents("user_IDs.php")) {
        $fileContent=file_get_contents("user_IDs.php");
        $fileContent=str_replace(["<?php","?>"],["",""],$fileContent);
        $file=fopen("user_IDs.php","w");
        fwrite($file,"<?php\n$file\n\$_USERID[\"".$_COOKIE["email"]."\"]=\"".rand(0,100000)."\";\n?>");
        fclose($file);
    } else {
        include("user_IDs.php");
        if ($_USERID[$_COOKIE["email"]]!=$_COOKIE["userid"] and $_COOKIE["userid"] and $_USERID[$_COOKIE["email"]]) {
            die("A bejelentkezési adatok érvénytelenek.");
        }
    }
    
}
?>