<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<!-- The source of the headers: https://stackoverflow.com/questions/13640109/how-to-prevent-browser-cache-for-php-site -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Page-Enter" content="blendTrans(Duration=1.0)"/>
<meta http-equiv="Page-Exit" content="blendTrans(Duration=1.0)"/>
<meta http-equiv="Site-Enter" content="blendTrans(Duration=1.0)"/>
<meta http-equiv="Site-Exit" content="blendTrans(Duration=1.0)"/>
<body>
<p>A weboldal átdolgozás alatt áll.</p>
<?php
if (!isset($_COOKIE["email"])) {
    die("Mivel nem jelentkeztél be, nem tudsz szerkeszteni. Bejelentkezni <a href='./preLogIn.php'>itt</a> tudsz.");
}
include("./emailAddressesandUsernames.php");
include("./userBlacklist.php");
?>
<form method="post" action="./addtheorem.php">
<input type="number" name="goedel_number_of_the_theorem" required placeholder="A tétel Gödel-száma" value="<?php
if ($_GET ["gnum"]) {
echo ($_GET ["gnum"]);
};
?>"/>
<?php if (!isset($_GET["editversion"])) { echo "<!--"; } ?>
<input type="hidden" name="editversion" value="<?=$_GET["editversion"] ?>" disabled/>
<?php if (!isset($_GET["editversion"])) { echo "-->"; } ?>

<br />
<textarea name="ttnl" placeholder="A tétel emberi nyelven" required>
<?php
if ($_GET["gnum"]) {
    $gnum = $_GET["gnum"];
    // The source of the function: https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
    function tag_contents($string, $tag_open, $tag_close){
   foreach (explode($tag_open, $string) as $key => $value) {
       if(strpos($value, $tag_close) !== FALSE){
            $result[] = substr($value, 0, strpos($value, $tag_close));;
       }
   }
   return $result;
}
    $toParse = file_get_contents("./theorems/$gnum.xml");
    $parsedText = tag_contents($toParse, "<description>", "</description>");
    if(!isset($_GET["editversion"])) {
        $len = count($parsedText) - 1;
        $parsedText = $parsedText[$len];
    } else {
        $parsedText=$parsedText[(int)$_GET["editversion"]];
    }
    echo (str_replace("&","&amp;",$parsedText));
    
} else {
    echo("Nincs az URL-ben megadva a tétel Gödel-száma, így nem tudjuk lekérni az eredeti szöveget, a véletlen felülírások elkerülése végett nem menthető a szöveg.");
}
?>
</textarea>
<br />
<textarea placeholder="A tétel bizonyítása, Gödel-számozással leírva" required name="proof">
<?php
if ($_GET["gnum"]) {
    $gnum = $_GET["gnum"];
    $toParse = file_get_contents("./theorems/$gnum.xml");
    $parsedText = tag_contents($toParse, "<proof>", "</proof>");
    if(!isset($_GET["editversion"])) {
    $len = count($parsedText) - 1;
    $parsedText = $parsedText[$len];
    } else {
        $parsedText=$parsedText[(int)$_GET["editversion"]];
    }
    echo (str_replace("&","&amp;",$parsedText));

} else {
    echo("Nincs az URL-ben megadva a tétel Gödel-száma, így nem tudjuk lekérni az eredeti szöveget, a véletlen felülírás elkerülése végett nem menthető el a szöveg.");
}
?>
</textarea>
<br/>
<input type="text" name="changes" placeholder="Min változtattál?" />
<input type="submit" value="Beküldés" />
</form>
</body>
</html>
<?php
if ($_POST["goedel_number_of_the_theorem"] and $_POST ["ttnl"] and $_POST ["proof"]) {
$gnott = $_POST["goedel_number_of_the_theorem"];
$ttnl = $_POST["ttnl"];
$proof = $_POST["proof"];
$changes = $_POST["changes"];
date_default_timezone_set("Budapest");
$date = date("Y. m. d., h:i:sa");
$contentToParse=file_get_contents("./theorems/".$gnott.".xml");
$contentToParse=str_replace("<xml>","",$contentToParse);
$contentToParse=str_replace("</xml>","",$contentToParse);
$file=fopen("./theorems/".$gnott.".xml","w");
fwrite($file,"<xml>".$contentToParse);
fclose($file);
$file = fopen ("./theorems/".$gnott.".xml", "a");
$author = $_COOKIE["email"];
if ($_USERNAME[$author]) {
    $author = $_USERNAME[$author];
};
$len1=count(str_split($proof),1);
$len2=count(str_split($ttnl),1);
if (isset($_POST["editversion"])) {
    $changes.=" A szerkesztés a/z/ ".($_POST["editversion"]+1).". változatot vette alapul.";
}
fwrite($file, "<version>\n<date>$date</date><author>$author</author><proof>$proof</proof>\n<description>$ttnl</description>\n<changes>$changes</changes>\n<descriptionLength>$len2</descriptionLength>\n<proofLength>$len1</proofLength>\n</version></xml>");
fclose($file);
$file=fopen("./latestedits.inc", "a");
fwrite($file, "<tr><td>$gnott</td>   <td>$author</td>   <td>$date</td>   <td>$changes</td></tr>");
fclose($file);
header ("Location: /hu/TheoDef/?gnum=".$gnott);
};
?>