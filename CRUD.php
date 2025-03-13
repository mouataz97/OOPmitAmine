<?php
const STORAGE = 'todos.txt';

class CRUD
{
    private $todos;

    public function __construct()
    {
        $this->todos = $this->readTodos();
    }

    public function getTodos(): array
    {
        return $this->todos;
    }

    public function insertOrUpdate(int $key): void
    {
        $todo = trim($_POST['todo']);
        if (empty($todo)) {
            die("Todo cannot be empty.");
        }

        if ($key === -1) {
            // Insert new todo
            $this->todos[] = $todo;
        } else {
            // Update existing todo
            if (isset($this->todos[$key])) {
                $this->todos[$key] = $todo;
            }
        }

        $this->saveTodos();
        header("Location: index.php");
        exit;
    }

    public function delete(int $key): void
    {
        if (isset($this->todos[$key])) {
            unset($this->todos[$key]);
            $this->todos = array_values($this->todos); // Reindex array
            $this->saveTodos();
        }

        header("Location: index.php");
        exit;
    }

    public function getTodo(int $key): string
    {
        return $this->todos[$key] ?? '';
    }

    private function readTodos(): array
    {
        if (!file_exists(STORAGE)) {
            return [];
        }

        $todos = file_get_contents(STORAGE);
        return array_filter(explode(PHP_EOL, $todos), 'trim');
    }

    private function saveTodos(): void
    {
        file_put_contents(STORAGE, implode(PHP_EOL, $this->todos));
    }
}