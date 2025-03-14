<?php

/** todo
 * 1. change the storage from text file to csv
 * 2. add field for priority of the task (priority: low, medium, height, urgent)
 * 3. add field for task's due date (expiration date)
 * 4. keep field for task description (todo already exists)
 */


require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/TodoStorage.php';
require_once __DIR__ . '/TodoController.php';

$todoStorage = new TodoStorage();
$todoController = new TodoController($todoStorage);

$defaultTodoValue = $todoController->getDefaultTodoValue();
$key = $todoController->getKey();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="container mt-5">
    <h1 class="mb-4">My Todos</h1>

    <!-- Todo Form -->
    <form action="index.php" method="POST">
        <div class="mb-3">
            <label for="todo" class="form-label">Todo</label>
            <input type="text" class="form-control" name="todo" id="todo"
                   value="<?php echo htmlspecialchars($defaultTodoValue); ?>" required>
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
            <?php foreach ($todoStorage->getTodos() as $key => $todo): ?>
                <tr>
                    <td>
                        <form action="index.php" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this todo?');">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>