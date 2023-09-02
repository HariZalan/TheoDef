<?php
function compare($a,$b,$c,$d) {
    $a=str_split(str_replace(["ő","ö","ú","ű","ü","á","ä","ó","ú"],"~",$a));
    $b=str_split(str_replace(["ő","ö","ú","ű","ü","á","ä","ó","ú"],"~",$b));
    $c=str_split(str_replace(["ő","ö","ú","ű","ü","á","ä","ó","ú"],"~",$c));
    $d=str_split(str_replace(["ő","ö","ú","ű","ü","á","ä","ó","ú"],"~",$d));
    for ($i=0; $a[$i]; $i++) {
        if ($a[$i]=="�") {
            $a[$i]="~";
    }
    }
    for ($i=0; $b[$i]; $i++) {
        if ($b[$i]=="�") {
            $b[$i]="~";
    }
    }
    
    $proofmove=count($a)-count($b);
    $descriptionmove=count($c)-count($d);
    $comparison1="";
    $comparison2="";
    // Now, we should use the $proofmove and the $descriptionmove
    for($i=0; $a[$i]|$b[$i]; $i++) {
        if($a[$i]==$b[$i]) {
            $comparison1.=$a[$i];
        } else {
            $comparison1.="(".$a[$i]."–&gt;".$b[$i].")";
        }
    }
    $comparisons=[];
    $comparisons[0]=$comparison1;
    $comparisons[1]=$comparison2;
    return $comparisons;
}
if (isset($_GET["gnum"]) and isset($_GET["versions"])) {
    $gnum=$_GET["gnum"];
    $versions=explode(",",$_GET["versions"]);
    $versionA=$versions[0];
    $versionB=$versions[1];
    $xml=file_get_contents("./theorems/$gnum.xml");
    // The source of the function: https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
    function tag_contents($string, $tag_open, $tag_close){
        foreach (explode($tag_open, $string) as $key => $value) {
            if(strpos($value, $tag_close) !== FALSE){
                $result[] = substr($value, 0, strpos($value, $tag_close));
            }
        }
         return $result;
    }
    $descriptionA=tag_contents($xml,"<description>","</description>")[(int)$versionA];
    $descriptionB=tag_contents($xml,"<description>","</description>")[(int)$versionB];
    $proofA=tag_contents($xml,"<proof>","</proof>")[(int)$versionA];
    $proofB=tag_contents($xml,"<proof>","</proof>")[(int)$versionB];
    echo(
    "Az egyik változat tételleírása:
    <pre>".htmlspecialchars($descriptionA)."</pre>
    A másiké:
    <pre>".htmlspecialchars($descriptionB)."</pre>
    Az egyik változat bizonyítása: <pre>".htmlspecialchars($proofA)."</pre>
    A másiké: <pre>".htmlspecialchars($proofB)."</pre>
    ");
    echo ("Tesztelés alatt álló funkció: ".compare($proofA,$proofB,"","")[0]);
}
?>