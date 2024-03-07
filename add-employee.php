<?php

require_once("database/Database.php");
require_once('Model/Employee.php');

$database = new OneHRMS\database\Database();
$db = $database->connect();

$employee = new OneHRMS\Model\Employee($db);

$errors = [];

$data = [
    'firstName'  =>  '',
    'lastName'  =>  '',
    'Email'  =>  '',
    'Salary'  =>  '',
    'Department'  =>  ''
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'firstName'  =>  $_POST['firstName'],
        'lastName'  =>  $_POST['lastName'],
        'Email'  =>  $_POST['Email'],
        'Salary'  =>  $_POST['Salary'],
        'Department'  =>  $_POST['Department']
    ];

    $employee->firstName = $data['firstName'];
    $employee->lastName = $data['lastName'];
    $employee->Email = $data['Email'];
    $employee->Salary = $data['Salary'];
    $employee->Department = $data['Department'];

    $errors = $employee->Validate($data);


    if (count($errors) === 0) {
        $result = isset($_POST['id']) ? $employee->update($_POST['id']) : $employee->add();

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            echo 'Error in saving employee.';
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $exiting_employee = $employee->findOne($employee_id);
    if ($exiting_employee) {
        $data = $exiting_employee;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One HRMS | Manage Employees</title>
    <?php require_once('partials/header.php'); ?>
</head>

<body>
    <?php require_once('partials/navbar.php'); ?>
    <div class="d-flex">
        <?php require_once('partials/sidebar.php'); ?>
        <div class="container-fluid main-content">
            <div class="row">
                <div class="col mt-3">
                    <h2 class="mb-3">
                        <?php if (isset($employee_id)) :  ?>
                            Edit Employees</h2>
                <?php else : ?>
                    Add Employee
                <?php endif; ?>
                <hr />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php if ($errors) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="employee-form">
                        <?php if (isset($employee_id)) : ?>
                            <input type="hidden" name="id" value="<?php echo $employee_id; ?>">
                        <?php endif ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first-name">First Name: <span class="required-fill">*</span> </label>
                                    <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo htmlspecialchars($data['firstName']); ?>" required />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="last-name">Last Name: <span class="required-fill">*</span></label>
                                    <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo htmlspecialchars($data['lastName']); ?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email">Email: <span class="required-fill">*</span></label>
                                    <input type="email" class="form-control" name="Email" id="email" value="<?php echo htmlspecialchars($data['Email']); ?>" required />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="salary">Salary:</label>
                                    <input type="text" class="form-control" name="Salary" id="salary" value="<?php echo htmlspecialchars($data['Salary']); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="department">Department:</label>
                                    <input type="text" class="form-control" name="Department" id="department" value="<?php echo  htmlspecialchars($data['Department']); ?>" />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning" onclick="formReset()">Clear</button>
                        <button type="submit" class="btn btn-success">
                            <?php if (isset($employee_id)) : ?>
                                Update
                            <?php else : ?>
                                Save
                            <?php endif; ?>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php
    $db->close();
    require_once('partials/footer.php');
    ?>
</body>

</html>