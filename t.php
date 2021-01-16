<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
<?php
    var_dump($_SERVER);
    $fileName = $_SERVER['PHP_SELF'];
    echo $fileName;
    var_dump(explode(".", $fileName));
?>
</body>
</html>