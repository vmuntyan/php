<?php
include 'db.php';

$action = $_POST['action'];

switch ($action) {
    case 'create_root':
        $stmt = $conn->prepare("INSERT INTO nodes (name) VALUES ('root')");
        $stmt->execute();
        echo json_encode(["id" => $conn->lastInsertId()]);
        break;

    case 'add_node':
        $parent_id = $_POST['parent_id'];
        $stmt = $conn->prepare("INSERT INTO nodes (name, parent_id) VALUES ('node', ?)");
        $stmt->execute([$parent_id]);
        echo json_encode(["id" => $conn->lastInsertId()]);
        break;

    case 'delete_node':
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM nodes WHERE id = ? OR parent_id = ?");
        $stmt->execute([$id, $id]);
        break;

    case 'edit_node':
        $id = $_POST['id'];
        $name = $_POST['name'];
        $stmt = $conn->prepare("UPDATE nodes SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
        break;

    case 'get_nodes':
        $stmt = $conn->query("SELECT * FROM nodes");
        $nodes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($nodes);
        break;
}
?>
