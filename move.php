<?php
session_start();
include("emailAddressesandUsernames.php");
if (isset($_GET["old_gnum"]) and isset($_GET["new_gnum"])) {
  if (isset($_COOKIE["email"])) {
      $content = file_get_contents("./theorems/".$_GET["old_gnum"].".xml");
      $content=str_replace(["<xml>","</xml>"],["",""],$content);
      if ($_GET["summary"]) {
      $content="<xml>".$content."<version>\n<date>".date("Y. m. d., h:i:sa")."</date><author>".$_USERNAME[$_COOKIE["email"]]."</author>\n<changes>".$_GET["old_gnum"]." Gödel-szám cseréje ".$_GET["new_gnum"]."-ra/re, indoklás: ".$_GET["summary"]."</changes>\n</version>";
      } else {
          $content="<xml>".$content."<version>\n<date>".date("Y. m. d., h:i:sa")."</date><author>".$_USERNAME[$_COOKIE["email"]]."</author>\n<changes>".$_GET["old_gnum"]." Gödel-szám cseréje ".$_GET["new_gnum"]."-ra/re</changes></version>";
      }
      if (!$content) {
        echo ("Az eredeti címen nem érhető el cikk.");  
      };
      $test = file_get_contents("./theorems/".$_GET["new_gnum"].".xml");
      if ($test) {
          die ("A célcím már foglalt.");
      };
      $file = fopen("./theorems/".$_GET["new_gnum"].".xml","w");
      fwrite($file,$content);
      fclose($file);
      unlink("./theorems/".$_GET["old_gnum"].".xml");
      $file = fopen("./theorems/".$_GET["new_gnum"].".xml","a");
      fwrite($file,"");
      fclose ($file);
  } else {
    die ("Be kell jelentkezned.");  
  };
} else {
    die("Meg kell adnod mind a régi, mind az új címet (Gödel-számot). URL-paraméternevek: old_gnum, new_gnum.");
};
?>