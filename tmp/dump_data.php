<?php
$conn = mysqli_connect('localhost', 'root', '', 'antygravity_ugs');
$res = mysqli_query($conn, "SELECT id, title, icon_class FROM services");
$data = [];
while($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}
file_put_contents('tmp/db_data.json', json_encode($data, JSON_PRETTY_PRINT));
?>
