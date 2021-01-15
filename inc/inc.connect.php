<?php

include("inc.global_variables.php");
try
{
    $conn = new PDO("$db_driver:host=$db_host;dbname=$db_name", $db_user, $db_pasword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>