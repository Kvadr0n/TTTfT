<html lang="en">
<head>
<title>Hello world page</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<table>
    <tr><th>ID</th><th>Name</th><th>Actual</th><th>Pass</th></tr>
<?php
$mysqli = new mysqli("mysql", "admin", "Franklin5", "userDB");
$result = $mysqli->query("SELECT * FROM auth");
foreach ($result as $row){
	echo "<tr><td>{$row['ID']}</td><td>{$row['name']}</td><td>{$row['actual']}</td><td>{$row['pass']}</td></tr>";
}
?>
</table>
<?php
phpinfo();
?>
</body>
</html>