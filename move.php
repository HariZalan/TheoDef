<?php
if (isset($_GET["old_gnum"]) and isset($_GET["new_gnum"])) {
  if ($_SESSION["email"]) {
      $content = file_get_contents("./theorems/".$_GET["old_gnum"].".xml");
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
      // "<version>\n<current />\n<date>$date</date><author>$author</author><proof>$proof</proof>\n<description>$ttnl</description>\n<changes>$changes</changes>\n</version>
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