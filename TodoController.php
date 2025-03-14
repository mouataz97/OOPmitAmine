<?php
declare(strict_types=1);

// todo read dependency injection
class TodoController
{
    private int $key;
    private string $defaultTodoValue = '';

    private TodoStorage $todoStorage;

    public function __construct(TodoStorage $todoStorage)
    {
        $this->todoStorage = $todoStorage;
        $this->key = isset($_POST['key']) ? (int)$_POST['key'] : -1;

        // decides to create or not
        if ($this->shouldCreate()) {
            // actually to creates a new record
            $this->create();
        }

        // decides to update or not
        if ($this->shouldUpdate()) {
            // actually to updates the record
            $this->update();
        }
        // actually to deletes the record
        if ($this->shouldDelete()) {
            // actually to deletes the record
            $this->delete();
        }

        // actually to edits the record
        if ($this->shouldEdit()) {
            // actually to edits the record
            $this->edit();
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
        return $this->isPostMethod() && isset($_POST['todo']) &&  $this->key >= 0;
    }

    private function create(): void
    {
        $todo = trim($_POST['todo']);
        if (empty($todo)) {
            die("Todo cannot be empty.");
        }

        $this->todoStorage->insert($todo);

        $this->redirectBack();
    }
    private function update(): void
    {
        $todo = trim($_POST['todo']);
        if (empty($todo)) {
            die("Todo cannot be empty.");
        }

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
        return $this->isPostMethod() && isset($_POST['edit']);
    }

    private function edit(): void
    {
        $this->defaultTodoValue = $this->todoStorage->getTodo($this->key);
    }

    public function getKey(): int
    {
        return $this->key;
    }

    public function getDefaultTodoValue(): string
    {
        return $this->defaultTodoValue;
    }

    private function shouldCreateOrUpdate(): bool
    {
        return $this->isPostMethod() && isset($_POST['todo']);
    }

}