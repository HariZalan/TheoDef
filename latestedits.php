<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<meta charset="utf-8"/>
</head>
<body>
<?php echo ("<table>".file_get_contents("latestedits.inc")."</table>"); ?>
</body>
</html>