<?php
session_start();
if (isset($_SESSION["email"])) {
    echo ("
    <!DOCTYPE html>\n
    <html>\n
    <head>\n
    <meta charset=\"utf-8\"/>\n
    <title>Regisztráció</title>
    </head>\n
    <body>\n
    <form action=\"registration.php\" method=\"post\">\n
    <input name=\"username\" placeholder=\"Felhasználónév\"/>
    <input type=\"submit\" value=\"Regisztráció\"/>
    </form>\n
    </body>\n
    </html>
    ");
    
    if (isset($_POST["username"])) {
        include("emailAddressesandUsernames.php");
        if ($_USERNAME[$_SESSION["email"]]) {
          die("Már regisztráltál.");
        };
        if (str_replace("\"".$_POST["username"]."\"","",file_get_contents("emailAddressesandUsernames.php")) != file_get_contents("emailAddressesandUsernames.php")) {
          die("Valaki megelőzött, válassz másik felhasználónevet.");  
        };
        $file=fopen("./emailAddressesandUsernames.php","a");
        fwrite($file,'<?php $_USERNAME["'.htmlspecialchars($_SESSION["email"]).'"] = "'.$_POST["username"].'" ?> ');
        fclose($file);
        echo ("Regisztráltál");
    }
} else {
    header("Location: /hu/TheoDef/preLogIn.php");
}
?>