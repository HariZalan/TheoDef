<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Keresési eredmények</title>
</head>
<body>
<?php
if(isset($_GET["q"])) {
    echo("<!--");
};
?>
<form action="./fullTextSearch.php">
    <input type="text" placeholder="A keresett szöveg" name="q"/>
    <input type="submit" value="Keresés"/>
</form>
<?php
if(isset($_GET["q"])) {
    // The source of the function: https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
    function tag_contents($string, $tag_open, $tag_close){
   foreach (explode($tag_open, $string) as $key => $value) {
       if(strpos($value, $tag_close) !== FALSE){
            $result[] = substr($value, 0, strpos($value, $tag_close));;
       }
   }
   return $result;
}
    echo("-->");
    $q=$_GET["q"];
    $files=scandir("./theorems");
    require"./goedel_numbers->algebratic_signs.inc.php";
    $files2=array();
    $files3=array();
    $str="";
    $result="";
    for ($k=2; $files[$k]; $k++) {
        $files[$k] = str_replace(".xml","",$files[$k]);
    }
    for ($i=2; $files[$i]; $i++) {
        $content=file_get_contents("./theorems/".$files[$i].".xml");
        $tagged_proof=tag_contents($content,"<proof>","</proof>");
        $tagged_proof=$tagged_proof[(count($tagged_proof)-1)];
        $tagged_description=tag_contents($content,"<description>","</description>")[count(tag_contents($content,"<description>","</description>"))-1];
        if ((str_replace($q,"",$tagged_proof)!=$tagged_proof) or (str_replace($q,"",$tagged_description)!=$tagged_description)) {
         $files2[$i]=str_split($files[$i],2);
         for ($j=0; $files2[$i][$j]; $j++) {
             $str.=$_TRANSLATOR[$files2[$i][$j]];
         }
        $files3[$i]=$str;
        $str="";

         $result.="<a href=\"./?gnum=".$files[$i]."\">".$files3[$i]."</a><br/>";
        }
    }
    if (!$result) {
        echo "Nincs találat e kifejezésre. Vedd figyelembe, hogy a kereső jelenleg megkülönbözteti a kis- s nagybetűket, és nem támogatja a reguláris kifejezéseket";
    }
    echo $result;
}
?>
</body>
</html>