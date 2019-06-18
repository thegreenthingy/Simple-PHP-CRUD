<?php
    // connect
    $db = mysqli_connect("localhost", "root", "", "crud");

    // initialize
    $id = 0;
    $column1 = "";
    $column2 = "";
    $column3 = "";
    $change = false;

    // insert
    if(isset($_POST['submit'])){
        $column1 = $_POST['column1'];
        $column2 = $_POST['column2'];
        $column3 = $_POST['column3'];

        $query = "INSERT INTO tablename (column1, column2, column3) VALUES ('$column1', '$column2', '$column3')";

        mysqli_query($db, $query);
        header('location: crud.php');
    }

    // retrieve
    $result = mysqli_query($db, "SELECT * FROM tablename");

    // update
    if(isset($_POST['update'])){
        $id = mysqli_real_escape_string($db, $_POST['id']);
        $column1 = mysqli_real_escape_string($db, $_POST['column1']);
        $column2 = mysqli_real_escape_string($db, $_POST['column2']);
        $column3 = mysqli_real_escape_string($db, $_POST['column3']);

        mysqli_query($db, "UPDATE tablename SET column1 = '$column1', column2 = '$column2', column3 = '$column3' WHERE id = $id");
        header('location: crud.php');
    }

    // change
    if(isset($_GET['change'])){
        $id = $_GET['change'];
        $change = true;
        $data = mysqli_query($db, "SELECT * FROM tablename WHERE id = $id");
        $row = mysqli_fetch_array($data);
        $column1 = $row['column1'];
        $column2 = $row['column2'];
        $column3 = $row['column3'];
        $id = $row['id'];
    }

    // delete
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        mysqli_query($db, "DELETE FROM tablename WHERE id = $id");
        header('location: crud.php');
    }
?>

<html>
    <head>
        <title>CRUD</title>

        <style>
            table, td, th{
                border: 1px solid black;
            }
        </style>
    </head>

    <body>
        <form action="" method="post">
            <pre>
                <input type="hidden" name="id" value="<?= $id ?>">
                Column1: <input name="column1" value="<?= $column1 ?>">
                Column2: <input name="column2" value="<?= $column2 ?>">
                Column3: <input name="column3" value="<?= $column3 ?>">

                <?php if($change == false): ?>
                    <button type="submit" name="submit">Submit</button>
                <?php else: ?>
                    <button type="submit" name="update">Update</button>
                <?php endif ?>
            </pre>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Column1</th>
                    <th>Column2</th>
                    <th>Column3</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    while($row = mysqli_fetch_array($result)){
                ?>

                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['column1']; ?></td>
                    <td><?= $row['column2']; ?></td>
                    <td><?= $row['column3']; ?></td>
                    <td>
                        <a href="crud.php?change=<?= $row['id']; ?>"><button>Edit</button></a>
                        <a href="crud.php?delete=<?= $row['id']; ?>"><button>X</button></a>
                    </td>
                </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>