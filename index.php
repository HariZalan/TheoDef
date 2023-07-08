<?php
// The source of the function: https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
    function tag_contents($string, $tag_open, $tag_close){
   foreach (explode($tag_open, $string) as $key => $value) {
       if(strpos($value, $tag_close) !== FALSE){
            $result[] = substr($value, 0, strpos($value, $tag_close));;
       }
   }
   return $result;
}
if ($_GET["gnum"]) {
include("./goedel_numbers->algebratic_signs.inc.php");
$toTranslate=str_split($_GET["gnum"],2);
$translated="";
for ($i = 0; $toTranslate[$i]; $i++) {
$translated .= $_TRANSLATOR[$toTranslate[$i]];
};
};
echo ("<!DOCTYPE html><html>\n<head>\n<meta charset='utf-8' />\n<title>TheoDef</title>\n<link rel='stylesheet' href='./stylesheet.css?preventCaching".rand(1000,100000)."'/>\n</head>\n<body>\n");
echo ("<a href='about.html' class='header'>Mi a TheoDef?</a><a href='./help.html' class='header'>Az itt használt Gödel-számozás leírása</a><a href='reports.php' class='header'>Technikai hibák jelentése, segítségkérés, javaslattétel</a><a href='./latestedits.php' class='header'>A szerkesztéslista (2023. június 27., 17:40-től van benne minden információ, ami a változatokhoz tartozik a tartalom mellett)</a><br/><br/>");
echo ("<span class='header'>A weboldal jelenleg átdolgozás alatt áll, előfordulhat egyes funkciók átmeneti működésképtelensége.</span> <p><h1>$translated</h1></p><p></p>");
if (isset ($_GET ["gnum"])) {
  $gnum = $_GET ["gnum"];
  $toParse = file_get_contents("./theorems/$gnum.xml");
  $toParse = str_ireplace("<script","&lt;script",$toParse);
  $toParse = str_ireplace("script>","script&gt;",$toParse);
  $toParse = str_ireplace('/javascript">','/javascript"&gt;',$toParse);
  $toParse = str_ireplace("onclick=","onlick=",$toParse);
  $toParse = str_ireplace("onhover=","onhoer=",$toParse);
  $toParse = str_ireplace("onload=","onoad=",$toParse);
  if ($toParse) {
    echo("<a href='addtheorem.php?gnum=$gnum' class='header'>Módosítás</a><a href='viewAllversions.php?gnum=$gnum'>Összes változat megtekintése</a><br/><br/>");
    $parsedText = tag_contents($toParse, "<description>", "</description>");
    $len = count($parsedText) - 1;
    $parsedText = $parsedText[$len];
    echo ("<p>A tétel érthetőbb formában: ".$parsedText."</p>");
    $parsedText = tag_contents($toParse, "<proof>", "</proof>");
    $len = count($parsedText) - 1;
    $parsedText = $parsedText[$len];
    echo ("<p>A bizonyítás: ".$parsedText."</p>");
} else {
    echo ("Az ezen Gödel-számmal bíró állítás hamis, ilyen tételt még senki nem küldött be, vagy nonszensz a Gödel-szám. A második fennállta esetén kattints <a href='addtheorem.php?gnum=$gnum'>ide</a>, és küldd be.");
}
} else {
/*if (isset($_GET ["gnum"])) {
$gnum = $_GET["gnum"];
$x = file_get_contents ("./theorems/".$gnum);
$y = file_get_contents ("./theorems/".$gnum.".proof");
$z = file_get_contents ("./authordata/".$gnum."_author");
if ($x and $y) {
echo ("<p>A $gnum Gödel-számmal bíró tétel emberek számára feldolgozhatóbb formában: </p><p>".$x."</p>"."<p>Bizonyítás:</p>".$y."<p>Szerző: $z </p>");
} elseif ($x and !$y) {
echo ("Már van ilyen tétel, de bizonyítás még nincs hozzá. A tétel Gödel-száma: $gnum. Emberek számára feldolgozhatóbb formában: ".$x);
} else {
echo ("Egyelőre nincs ilyen Gödel-számú tételünk. <a href='./addtheorem.php?gnum=$gnum'>Ide</a> kattintva megírhatod emberek számára értelmezhető formában, és beküldhetsz rá gépi bizonyítást.");
};
} else {
echo ("A TheoDef-ben található tételek:<br />");
$file = file_get_contents("./theorem_list.txt");
$_WORDS = explode ("––", $file);
for ($x = 0; $_WORDS [$x]; $x++) {
echo ("<a href='?gnum=$_WORDS[$x]' class='theList'>".$_WORDS[$x]."</a><br />");
};
};

*/

$files=scandir("theorems/");
$string = "<p>A TheoDefben található tételek: </p>";
for ($i = 2; $files[$i]; $i++) {
    $string.="<a href='?gnum=".str_replace(".xml","",$files[$i])."'>".str_replace(".xml","",$files[$i])."</a><br/>";
};
echo ($string);
};
?>
