<?php
include "db.php";
$editMode = false;
$editData = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $id = $_GET['edit'];

    $stmt = $con->prepare("SELECT * FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
}
?>
<html>

<head>
    <title>Student</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
    <?php
    function oldValue($data, $key)
    {
        return $data[$key] ?? '';
    }
    function checked($data, $key, $value)
    {
        if (($data[$key] ?? '') == $value) {
            return "checked";
        }
        return "";
    }
    ?>
    <div class="row justify-content-center mb-5">
        <div class="mt-5 col-md-8">
            <div class="card shadow-lg border-0 rounded-4 p-4 bg-light text-primary">
                <h1 class="text-center text-primary mb-4">Student Form</h1>
                <form action="insert.php" method="POST">
                    <input type="hidden" name="id" value="<?= oldValue($editData, 'id') ?>">
                    <div class="mb-3">
                        <label for="name" class="fw-bold">Name:</label>
                        <input id="name" type="text" name="name" value="<?= oldValue($editData, 'name') ?>" class="form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="fName" class="fw-bold">Father Name:</label>
                        <input id="fName" type="text" name="fName" value="<?= oldValue($editData, 'fName') ?>" class="form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="fw-bold">Age:</label>
                        <input id="age" type="number" name="age" value="<?= oldValue($editData, 'age') ?>" class="form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="fw-bold">Class:</label>
                        <input id="class" type="text" name="class" value="<?= oldValue($editData, 'class') ?>" class="form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="fw-bold">Phone:</label>
                        <input id="phone" type="number" name="phone" value="<?= oldValue($editData, 'phone') ?>" class="form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="fw-bold">Address:</label>
                        <textarea id="address" name="address" class="form-control bg-light rounded-3" rows="2" required> <?= trim(oldValue($editData, 'address')) ?> </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="fw-bold">Email:</label>
                        <input id="email" type="email" name="email" value="<?= oldValue($editData, 'email') ?>" class="form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="fw-bold">Gender:</label> <br>
                        <label for="male">
                            <input type="radio" name="gender" id="male" value="male" <?= checked($editData, 'gender', 'male') ?>>Male
                        </label>
                        <label for="female">
                            <input type="radio" name="gender" id="female" value="female" <?= checked($editData, 'gender', 'female') ?>>Female
                        </label>
                        <label for="other">
                            <input type="radio" name="gender" id="other" value="other" <?= checked($editData, 'gender', 'other') ?>>Other
                        </label>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary ">
                            <?php echo isset($editData) ? "Update" : "Submit" ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div class="mt-5 col-md-11">
            <div class="card shadow-lg border-0 rounded-4 bg-light">
                <h1 class="text-center text-primary mb-4">Student Records</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>Age</th>
                                <th>Class</th>
                                <th>Phone</th>
                                <th>Adress</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $con->query("SELECT * FROM students") or die($con->error);
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['fName']; ?></td>
                                    <td><?php echo $row['age']; ?></td>
                                    <td><?php echo $row['class']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td class="text-center">

                                        <a href="index.php?edit=<?php echo $row['id']; ?>"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">
                                            X
                                        </a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
</body>

</html>