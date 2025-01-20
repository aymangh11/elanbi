<?php
$data = file_get_contents('php://input');
file_put_contents('blogs.json', $data);
echo "Blogs saved successfully!";
?>