<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=tree_nodes", "root", "88888888");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
