<?php

include('CRUD.php');

$crud = new CRUD();
$defaultTodoValue = '';
$key = -1;

// Handle form actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['todo'])) {
        // Insert or Edit action
        $key = isset($_POST['key']) ? (int)$_POST['key'] : -1;
        $crud->insertOrUpdate($key);
    } elseif (isset($_POST['delete'])) {
        // Delete action
        $key = (int)$_POST['delete'];
        $crud->delete($key);
    } elseif (isset($_POST['edit'])) {
        // Edit action (pre-fill form)
        $key = (int)$_POST['key'];
        $defaultTodoValue = $crud->getTodo($key);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEJ8vFf69+Kp7bDgQ4d8rbgHyyppF8g9Fq+VqP6XctbJl4gVtnZ1e+ZSKVd4A" crossorigin="anonymous">

    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="container mt-5">
    <h1 class="mb-4">My Todos</h1>

    <!-- Todo Form -->
    <form action="index.php" method="POST">
        <div class="mb-3">
            <label for="todo" class="form-label">Todo</label>
            <input type="text" class="form-control" name="todo" id="todo" value="<?php echo htmlspecialchars($defaultTodoValue); ?>" required>
        </div>
        <input type="hidden" name="key" value="<?php echo $key; ?>">
        <button type="submit" class="btn btn-primary"><?php echo $key === -1 ? 'Add Todo' : 'Edit Todo'; ?></button>
    </form>

    <div class="mt-4">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Action</th>
                <th>Todo</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($crud->getTodos() as $key => $todo): ?>
                <tr>
                    <td>
                        <form action="index.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?');">
                            <input type="hidden" name="delete" value="<?php echo $key; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                    <td>
                        <form action="index.php" method="POST">
                            <input type="hidden" name="edit" value="edit">
                            <input type="hidden" name="key" value="<?php echo $key; ?>">
                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($todo); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybF0J6E0eXdmZv6tYj6vGvEa10p6H5B5P5flDzH0p5M5yXw5I" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Yd3f7ccXeB1lWOM4clIHXJ1dA6a2gf2fQzq3p6g0GbpRtB2" crossorigin="anonymous"></script>
</body>
</html>