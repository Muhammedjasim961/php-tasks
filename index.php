<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One HRMS | Employees</title>
    <?php require_once('partials/header.php'); ?>

</head>

<body>
    <?php require_once('partials/navbar.php'); ?>
    <div class="d-flex">
        <?php require_once('partials/sidebar.php'); ?>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">Employees</h2>
                    <hr />
                </div>
            </div>
            <div class="text-end">
                <a href="add-employee.php" class="btn btn-primary btn-sm">Add Employee</a>
            </div>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Email</th>
                        <th>Salary</th>
                        <th>Department</th>
                        <th class="text-end">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                    require_once('database/Database.php');
                    require_once('Model/Employee.php');

                    $database  = new OneHRMS\database\Database();
                    $db = $database->connect();

                    $employee = new OneHRMS\Model\Employee($db);
                    $result = $employee->listAll();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // echo "<tr/>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['firstName'] . "</td>";
                            echo "<td>" . $row['lastName'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['Salary'] . "</td>";
                            echo "<td>" . $row['Department'] . "</td>";
                            echo "<td class='text-end'>
                                <a href= 'add-employee.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>
                                Edit
                                <a/>
                                <a href= 'delete-employee.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Delete<a/>
                                </td>";
                            echo "<tr/>";
                        }
                    } else {
                        echo "<tr>
                          <td colspan='7' class='text-center'>No Records Found!</td>
                          <tr/>";
                    }

                    $db->close();
                    ?>

                </tbody>
            </table>
        </div>
    </div>




    <?php require_once('partials/footer.php'); ?>

</body>

</html>