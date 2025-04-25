<?php

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
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Todo App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">My Todos</h1>

        <!-- Todo Form -->
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="todo" class="form-label">Todo Description</label>
                <input type="text" class="form-control" name="todo" id="todo" value="<?php echo htmlspecialchars($defaultTodoValue['description']); ?>" required>
            </div>

            <!-- Priority Dropdown -->
            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-control" name="priority" id="priority" required>
                    <option value="Urgent" <?php echo ($defaultTodoValue['priority'] === 'Urgent' ? 'selected' : ''); ?>>Urgent</option>
                    <option value="High" <?php echo ($defaultTodoValue['priority'] === 'High' ? 'selected' : ''); ?>>High</option>
                    <option value="Medium" <?php echo ($defaultTodoValue['priority'] === 'Medium' ? 'selected' : ''); ?>>Medium</option>
                    <option value="Low" <?php echo ($defaultTodoValue['priority'] === 'Low' ? 'selected' : ''); ?>>Low</option>
                </select>
            </div>

            <!-- Date and Time Picker -->
            <div class="mb-3">
                <label for="date" class="form-label">Due Date</label>
                <input type="datetime-local" class="form-control" name="date" id="date" value="<?php echo htmlspecialchars($defaultTodoValue['date']); ?>" required>
            </div>

            <!-- Hidden input to handle Add/Edit logic -->
            <input type="hidden" name="key" value="<?php echo $key; ?>">

            <button type="submit" class="btn btn-primary">
                <?php echo $key === -1 ? 'Add Todo' : 'Edit Todo'; ?>
            </button>
        </form>

        <div class="mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Todo</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($todoStorage->getTodos() as $key => $todo): ?>
        <tr>
            <td class="action-btns">
                <!-- Edit Button -->
                <form action="index.php" method="POST" style="display: inline-block;">
                    <input type="hidden" name="edit" value="<?php echo $key; ?>">
                    <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                </form>

                <!-- Delete Button -->
                <form action="index.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?');" style="display: inline-block;">
                    <input type="hidden" name="delete" value="<?php echo $key; ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
            <td><?php echo htmlspecialchars($todo['description']); ?></td>
            <td><?php echo htmlspecialchars($todo['priority']); ?></td>
            <td><?php echo htmlspecialchars($todo['date']); ?></td>
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
