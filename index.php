<?php
const  STORAGE = 'todos.txt';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    file_put_contents(STORAGE, PHP_EOL, FILE_APPEND);
    file_put_contents(STORAGE, $_POST['todo'], FILE_APPEND);
}

$todos = file_get_contents(STORAGE);
$todos = explode(PHP_EOL, $todos);
$todos = array_filter($todos);
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
        <ul>
            <?php
            foreach ($todos as $todo) {
                echo "<li>$todo</li>";
            }
            ?>
        </ul>
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