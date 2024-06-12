CREATE TABLE nodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id INT,
    has_children BOOLEAN DEFAULT 0,
    expanded BOOLEAN DEFAULT 0,
    FOREIGN KEY (parent_id) REFERENCES nodes(id) ON DELETE CASCADE
);