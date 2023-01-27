<?php 

try {
    $db = new PDO('mysql:host=localhost;dbname=lessons','root', '');
} catch (PDOException $e) {
   echo $e->getMessage();
}

?>