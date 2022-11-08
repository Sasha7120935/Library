<?php
/**
 * Created by Belous Alex.
 * Description: Mysql query
 * Date: 4/10/22
 */
spl_autoload_register();
\Classes\Databases::createDatabase();
?>
<!DOCTYPE html>
<html>
<head>
    <title>library</title>
    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<h2>List of users who took books</h2>
<?php
$conn = \Classes\Databases::database();
if (!$conn) {
    die("Error: " . mysqli_connect_error());
}
$sql = [
    "SELECT * FROM StartTime",
    "SELECT ba.UserId,a.User UserName,ba.BookId,b.Title BookTitle,ba.StartTimeId,c.Start StartTime,ba.EndTimeId,e.End EndTime, DATEDIFF(End, Start) AS days FROM UsersBooks ba INNER JOIN Users a ON a.id = ba.UserId INNER JOIN Books b ON b.id = ba.bookid INNER JOIN StartTime c ON c.id = ba.StartTimeId INNER JOIN EndTime e ON e.id = ba.EndTimeId;"
];
   foreach ($sql as $select) {
       if ($result = mysqli_query($conn, $select)) {
?>
<table class="table">
    <th scope="col">User</th>
    <th scope="col">Book</th>
    <th scope="col">Start</th>
    <th scope="col">End</th>
    <th scope="col">Day</th>
    <?php
    foreach ($result as $row) {
        echo "<tbody>";
        echo "<tr>";
        echo "<td>" . $row["UserName"] . "</td>";
        echo "<td>" . $row["BookTitle"] . "</td>";
        echo "<td>" . $row["StartTime"] . "</td>";
        echo "<td>" . $row["EndTime"] . "</td>";
        echo "<td>" . $row["days"] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    mysqli_free_result($result);
    } else {
        echo "Ошибка: " . mysqli_error($conn);
    }
}
    mysqli_close($conn);
    ?>
</body>
</html>