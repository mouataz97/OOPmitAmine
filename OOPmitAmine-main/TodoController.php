<?php
declare(strict_types=1);

class TodoController
{
    private int $key;
    private array $defaultTodoValue;
    private TodoStorage $todoStorage;

    public function __construct(TodoStorage $todoStorage)
    {
        $this->todoStorage = $todoStorage;
        $this->key = isset($_POST['key']) ? (int)$_POST['key'] : -1;

        // Initialize defaultTodoValue safely
        $this->defaultTodoValue = [
            'description' => $_POST['todo'] ?? '',
            'priority' => $_POST['priority'] ?? 'Low',
            'date' => $_POST['date'] ?? ''
        ];

        // Check if editing an existing todo
        if ($this->shouldEdit()) {
            $this->edit();
        }

        // Process actions
        if ($this->shouldCreate()) {
            $this->create();
        }

        if ($this->shouldUpdate()) {
            $this->update();
        }

        if ($this->shouldDelete()) {
            $this->delete();
        }
    }

    private function shouldCreate(): bool
    {
        return $this->isPostMethod() && isset($_POST['todo']) && $this->key <= -1;
    }

    private function isPostMethod(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    private function redirectBack(): void
    {
        header("Location: index.php");
        exit;
    }

    private function shouldUpdate(): bool
    {
        return $this->isPostMethod() && isset($_POST['todo']) && $this->key >= 0;
    }

    private function create(): void
    {
        $todo = $this->getInfo();
        $this->todoStorage->insert($todo);
        $this->redirectBack();
    }

    private function update(): void
    {
        $todo = $this->getInfo();
        $this->todoStorage->update($this->key, $todo);
        $this->redirectBack();
    }

    private function shouldDelete(): bool
    {
        return $this->isPostMethod() && isset($_POST['delete']);
    }

    private function delete(): void
    {
        $this->key = (int) $_POST['delete'];
        $this->todoStorage->delete($this->key);
        $this->redirectBack();
    }

    private function shouldEdit(): bool
    {
        return isset($_POST['edit']);
    }

    private function edit(): void
    {
        // $todo = $this->todoStorage->getTodo($this->key);
        // $this->defaultTodoValue = $todo;
        $todo = $this->todoStorage->getTodo((int)$_POST['edit']);
        if (!empty($todo)) {
            $this->defaultTodoValue = $todo;
            $this->key = (int)$_POST['edit'];
        }
    }

    public function getKey(): int
    {
        return $this->key;
    }

    public function getDefaultTodoValue(): array
    {
        return $this->defaultTodoValue;
    }
    
    public function getInfo(): array
    {
        $description = $_POST['todo'] ?? '';
        $priority = $_POST['priority'] ?? 'Low';
        $date = $_POST['date'] ?? '';

        if (empty($description)) {
            die("Todo description cannot be empty.");
        }

        return [
            'description' => $description,
            'priority' => $priority,
            'date' => $date
        ];
    }
}
