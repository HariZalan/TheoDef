<?php
// The source of the function: https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
    function tag_contents($string, $tag_open, $tag_close){
   foreach (explode($tag_open, $string) as $key => $value) {
       if(strpos($value, $tag_close) !== FALSE){
            $result[] = substr($value, 0, strpos($value, $tag_close));;
       }
   }
   return $result;
};
function graph($parsedText) {
    $graph = tag_contents($parsedText,"<graph>","</graph>");
    $Graph = $graph[0];
    $graph2=str_replace(["whitep","blackp","break"],["<area shape=\"rect\" href=\"./white.svg\" class=\"graphpixel\"/>","<area shape=\"rect\" href=\"./black.svg\" class=\"graphpixel\"/>","<br/>"],$Graph);
    $parsedText=str_replace("<graph>$Graph</graph>","<map>".$graph2."</map>",$parsedText);
    return $parsedText;
};
include("./goedel_numbers->algebratic_signs.inc.php");
if ($_GET["gnum"]) {
$toTranslate=str_split($_GET["gnum"],2);
$translated="";
for ($i = 0; $toTranslate[$i]; $i++) {
$translated .= $_TRANSLATOR[$toTranslate[$i]];
};
};
$header=tag_contents(file_get_contents("./theorems/Fejléc.xml"),"<description>","</description>");
$header=$header[count($header)-1];
echo $header;
echo ("<h1>".$translated."</h1><p></p>");
if ($_GET ["gnum"]) {
  $gnum = $_GET ["gnum"];
  $toParse = file_get_contents("./theorems/$gnum.xml");
  $toParse = str_ireplace("<script","&lt;script",$toParse);
  $toParse = str_ireplace("script>","script&gt;",$toParse);
  $toParse = str_ireplace('/javascript">','/javascript"&gt;',$toParse);
  $toParse = str_ireplace("onclick=","onlick=",$toParse);
  $toParse = str_ireplace("onhover=","onhoer=",$toParse);
  $toParse = str_ireplace("onload=","onoad=",$toParse);
  $toParse=str_replace(["{{{{{","}}}}}"],["<em><strong>","</strong></em>"],$toParse);
  $toParse=str_replace(["{{{","}}}"],["<strong>","</strong>"],$toParse);
  $toParse=str_replace(["{{","}}"],["<em>","</em>"],$toParse);
  if ($toParse) {
    if (isset($_GET["version"]) and $_GET["version"]!=="") {
        $versionInfo="&editversion=".$_GET["version"];
    }
    echo("<a href='addtheorem.php?gnum=$gnum$versionInfo' class='header'>Módosítás"."</a><a href='viewAllversions.php?gnum=$gnum'>Összes változat megtekintése</a><br/><br/>");
    $parsedText = tag_contents($toParse, "<description>", "</description>");
    $innerLink="\$parsedText2=explode(\"Link\",\$parsedText);
    for (\$I=1; \$parsedText2[\$I]; \$I+=2) {
                if (str_replace(\"|\",\"\", \$parsedText2[\$I])!=\$parsedText2[\$I]) {
                \$parsedText2[\$I]=\"<a href='./?gnum=\".explode(\"|\",\$parsedText2[\$I])[0].\"'>\".explode(\"|\",\$parsedText2[\$I])[1].\"</a>\";
                } else {
                    \$parsedText2[\$I]=\"<a href='./?gnum=\".\$parsedText2[\$I].\"'>~~~\".\$parsedText2[\$I].\"~~~</a>\";

                }
        }
        \$parsedText=implode(\"\",\$parsedText2);
    ";
    $translate="
        \$parsedText2=explode(\"~~~\",\$parsedText);
    for (\$I=1; \$parsedText2[\$I]; \$I+=2) {
                \$x=str_split(\$parsedText2[\$I],2);
                \$parsedText2[\$I]=\"\";
        for (\$J=0; \$x[\$J]; \$J++) {
        \$parsedText2[\$I].=\$_TRANSLATOR[\$x[\$J]];
    
            }
        }
        \$parsedText=implode(\"\",\$parsedText2);
    ";
    $categorisate="\$parsedText2=explode(\"Cat\",\$parsedText);
    for (\$I=1; \$parsedText2[\$I]; \$I+=2) {
                \$parsedText2[\$I]=\"<a href='fullTextSearch.php?q=Cat\".\$parsedText2[\$I].\"Cat'>Az összes cikk a(z) „\".\$parsedText2[\$I].\"” témában</a>\";
        }
        \$parsedText=implode(\"\",\$parsedText2);
    ";
    if (isset($_GET["version"])) {
        $parsedText=$parsedText[$_GET["version"]];
        if (!$parsedText) {
            echo("Nincs ilyen változat.");
        }
    } else {
    $len = count($parsedText) - 1;
    $parsedText = $parsedText[$len];
    };
  //  $parsedText = graph($parsedText);
    eval($innerLink);
    eval($translate);
    eval($categorisate);
    echo ("<p>A tétel főleg szöveges formában: ".$parsedText."</p>");
    $parsedText = tag_contents($toParse, "<proof>", "</proof>");
    if (isset($_GET["version"])) {
        $parsedText=$parsedText[$_GET["version"]];
    } else {
    $len = count($parsedText) - 1;
    $parsedText = $parsedText[$len];
    }
    eval($innerLink);
    eval($translate);
    eval($categorisate);
    echo ("<p>A bizonyítás: ".$parsedText."</p>");
} else {
    echo ("Az ezen Gödel-számmal bíró állítás hamis, ilyen tételt még senki nem küldött be, vagy nonszensz a Gödel-szám. A második fennállta esetén kattints <a href='addtheorem.php?gnum=$gnum'>ide</a>, és küldd be.");
}
} else {
/*The code of the old version (https://zalan.withssl.com/TheoDef_old) to handle that:
if (isset($_GET ["gnum"])) {
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
    $toDisplay[$i]=str_replace(".xml","",$files[$i]);
    $toDisplay[$i]=str_split($toDisplay[$i],2);
    $toDisplayNew=[];
    for ($j = 0; $toDisplay[$i][$j]; $j++) {
    $toDisplayNew[$i].= $_TRANSLATOR[$toDisplay[$i][$j]];
    };
    $string.="<a href='?gnum=".str_replace(".xml","",$files[$i])."'>".$toDisplayNew[$i]."</a><br/>";
};
echo ($string."<form action=\"search.php\">\nA lekérni kívánt tételleírás tárgyának Gödel-száma (az alapértelmezett értéket megtartva a kezdőlapra visz a lap elején található „Mi a TheoDef?” és a felsorolásban található „MainPage” linkhez hasonlóan): \n<input type=\"number\" name=\"gnum\"  value=\"8532404588323836\"/>\n<input type=\"submit\" value=\"Lekérés\"/>\n</form>");
};
?>
