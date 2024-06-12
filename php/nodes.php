<?php
// Подключение к базе данных
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '88888888';
$dbName = 'tree_nodes';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];

switch ($action) {
    case 'create_root':
        $sql = "INSERT INTO nodes (name, parent_id) VALUES ('root', NULL)";
        if ($conn->query($sql) === TRUE) {
            $nodeId = $conn->insert_id;
            echo json_encode(['id' => $nodeId, 'name' => 'root', 'hasChildren' => false, 'expanded' => false]);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        break;
    case 'add_node':
        $parentId = $_POST['parent_id'];
        $sql = "INSERT INTO nodes (name, parent_id) VALUES ('node', $parentId)";
        if ($conn->query($sql) === TRUE) {
            $nodeId = $conn->insert_id;
            updateParentHasChildren($parentId, true);
            echo json_encode(['id' => $nodeId, 'name' => 'node', 'hasChildren' => false, 'expanded' => false]);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        break;
    case 'edit_node':
        $nodeId = $_POST['id'];
        $newName = $_POST['name'];
        $sql = "UPDATE nodes SET name='$newName' WHERE id=$nodeId";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        break;
    case 'delete_node':
        // Реализация удаления узла
        break;
    case 'get_nodes':
        $nodes = [];
        $sql = "SELECT * FROM nodes";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $nodes[] = $row;
            }
            echo json_encode($nodes);
        } else {
            echo "0 results";
        }
        break;
}

$conn->close();

function updateParentHasChildren($parentId, $hasChildren) {
    global $conn;
    $sql = "UPDATE nodes SET has_children=$hasChildren WHERE id=$parentId";
    $conn->query($sql);
}
?>
