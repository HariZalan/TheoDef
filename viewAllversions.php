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
$header=tag_contents(file_get_contents("./theorems/Fejléc.xml"),"<description>","</description>");
$header=$header[count($header)-1];
echo $header;
if (isset ($_GET ["gnum"])) {
  $gnum = $_GET ["gnum"];
  $toParse = file_get_contents("./theorems/$gnum.xml");
  if ($toParse) {
  $rawDescription = tag_contents($toParse,"<description>","</description>");
  $rawProof = tag_contents($toParse,"<proof>","</proof>");
  $toParse = str_ireplace("<script","&lt;script",$toParse);
  $toParse = str_ireplace("script>","script&gt;",$toParse);
  $toParse = str_ireplace('/javascript">','/javascript"&gt;',$toParse);
  $toParse = str_ireplace("onclick=","onlick=",$toParse);
  $toParse = str_ireplace("onhover=","onhoer=",$toParse);
  $toParse = str_ireplace("onload=","onoad=",$toParse);
  $toParse=str_replace("<xml>", "", $toParse);
  $toParse=str_replace("</xml>", "", $toParse);
  $toParse=str_replace("<version>", "<section class='version'>", $toParse);
  $toParse=str_replace("</version>", "</section>", $toParse);
  $toParse=str_replace("<description>", "<div class='description'>A változatbani tételleírás: ", $toParse);
  $toParse=str_replace("<descriptionLength>", "<div class='descriptionLength'>A változatbani tételleírás hossza byte-ban: ", $toParse);
  $toParse=str_replace("<proof>", "<div class='proof'>A változatbani bizonyítás: ", $toParse);
  $toParse=str_replace("<proofLength>", "<div class='proofLength'>A változatbani bizonyítás hossza byte-ban: ", $toParse);
  $toParse=str_replace("<author>", "<div class='author'>A változat szerzője: ", $toParse);
  $toParse=str_replace("<changes>", "<div class='changes'>Az előző változaton végzett változtatások összefoglalva: ", $toParse);
  $toParse=str_replace("<date>", "<hr/><div class='date'>A változat dátuma: ", $toParse);
  $toParse=str_replace("</description>", "</div>", $toParse);
  $toParse=str_replace("</descriptionLength>", "</div>", $toParse);
  $toParse=str_replace("</proof>", "</div>", $toParse);
  $toParse=str_replace("</proofLength>", "</div>", $toParse);
  $toParse=str_replace("</author>", "</div>", $toParse);
  $toParse=str_replace("</changes>", "</div>", $toParse);
  $toParse=str_replace("</date>", "</div>", $toParse);
 // foreach ($rawDescription as $i) {
    //$toParse=preg_replace("/<div class='description'>/","<div class='description' seen><p>A nyers kód:</p><code>".htmlspecialchars($rawDescription[$i])."</code><p>Így néz ki:</p>",$toParse,1);
 // };
 // foreach ($rawProof as $j) {
   //$toParse=preg_replace("/<div class='proof'>/","<div class='proof' seen><p>A nyers kód:</p><code>".htmlspecialchars($rawProof[$j])."</code><p>Így néz ki:</p>",$toParse,1);
//  };
  echo("<a href='./addtheorem.php?gnum=$gnum' style='padding-left: 10px'>Módosítás</a><br/><br/>".$toParse);
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
