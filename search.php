<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Keresési eredmények</title>
</head>
<body>
<?php
if(isset($_GET["gnum"])) {
    echo("<!--");
};
?>
<form action="./search.php">
    <input type="number" placeholder="Gödel-szám" name="gnum"/>
    <input type="submit" value="Keresés"/>
</form>
<?php
if(isset($_GET["gnum"])) {
    echo("-->");
    $gnum=$_GET["gnum"];
    $files=scandir("./theorems");
    require"./goedel_numbers->algebratic_signs.inc.php";
    $files2=array();
    $files3=array();
    $str="";
    for ($i=2; $files[$i]; $i++) {
        if (str_replace($gnum,"",$files[$i])!=$files[$i]) {
         $files[$i]=str_replace(".xml","",$files[$i]);
         $files2[$i]=str_split($files[$i],2);
         for ($j=0; $files2[$i][$j]; $j++) {
             $str.=$_TRANSLATOR[(string)$files2[$i][$j]];
             $files3[$i]=$str;
         }
         $str="";
         echo ("<a href=\"./?gnum=".$files[$i]."\">".$files3[$i]."</a><br/>");
        };
    }
};
?>
</body>
</html>