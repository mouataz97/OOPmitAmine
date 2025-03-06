<?php
const STORAGE = 'todos.txt';

$defaultTodoValue = '';
$key = -1;

$todos = readsTodoList();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['todo'])) {
    appendTodoList((int) $_POST['key'], $todos);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    deleteTodo(key:  (int) $_POST['delete'], todos: $todos);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit'])) {
    $key = (int) $_POST['key'];
    $defaultTodoValue = $todos[$key];
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
        <input type="text" name="todo" value="<?php echo $defaultTodoValue ?>">
        <input type="hidden" name="key" value="<?php echo $key ?>">
        <button type="submit">Add</button>
    </form>

    <div style="margin-top: 15px">
        <table>
            <?php foreach ($todos as $key => $todo): ?>
            <tr>
                <td>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="delete" value="delete">
                        <input type="hidden" name="key" value="<?php echo $key ?>">
                        <button type="submit"> delete </button>
                    </form>
                </td>
                <td>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="edit" value="edit">
                        <input type="hidden" name="key" value="<?php echo $key ?>">
                        <button type="submit"> edit </button>
                    </form>
                </td>
                <td><?php echo $todo ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
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

function appendTodoList(int $key, array $todos): void
{
    if ($key === -1) {
        file_put_contents(STORAGE, PHP_EOL, FILE_APPEND);
        file_put_contents(STORAGE, $_POST['todo'], FILE_APPEND);

        return;
    }

    if ($key !== -1) {
        $todos[$key] = $_POST['todo'];
        $input = implode(PHP_EOL, $todos);
        file_put_contents(STORAGE, $input);

        header( "Location: /" );
        exit;
    }
}

/**  @return string[] */
function readsTodoList(): array
{
    $todos = file_get_contents(STORAGE);
    $todos = explode(PHP_EOL, $todos);

    return array_filter($todos);
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

