<?php
const STORAGE = 'todos.txt';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['todo'])) {
    appendTodoList();
}

$todos = readsTodoList();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    deleteTodo(key:  (int) $_POST['delete'], todos: $todos);
}

?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Todo app</title>
    </head>
    <body>
    <h1>My Todos</h1>

    <form action="index.php" method="POST">
        <label>Todo</label>
        <input type="text" name="todo" placeholder="todo: apply to government jobs A, B and C...">
        <button type="submit">Add</button>
    </form>

    <div style="margin-top: 15px">
        <?php renderTodos($todos); ?>
    </div>
    </body>
    </html>

<?php


function dd(...$values): void
{
    echo '<pre>';
    var_dump(...$values);
    die();
}

function appendTodoList(): void
{
    file_put_contents(STORAGE, PHP_EOL, FILE_APPEND);
    file_put_contents(STORAGE, $_POST['todo'], FILE_APPEND);
}

/**  @return string[] */
function readsTodoList(): array
{
    $todos = file_get_contents(STORAGE);
    $todos = explode(PHP_EOL, $todos);

    return array_filter($todos);
}

function renderTodos(array $todos): void
{
    echo "<ul>";
    foreach ($todos as $key => $todo) {
        echo "<li style='margin-top: 10px'>";
        echo '<form action="index.php" method="POST">';
        echo '<input type="hidden" name="delete" value="' . $key . '">';
        echo '<button type="submit"> X </button>';
        echo " $todo";
        echo "</form>";
        echo "</li>";
    }
    echo "</ul>";
}

/** @param string[] $todos */
function deleteTodo(int $key, array $todos): void
{
    unset($todos[$key]);
    $input = implode(PHP_EOL, $todos);
    file_put_contents(STORAGE, $input);

    header( "Location: /" );
    exit;
}

