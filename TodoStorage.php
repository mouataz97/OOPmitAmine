<?php
declare(strict_types=1);
// todo read about clean coding
// todo read about Single responsibility principle 1 SOLID
class TodoStorage
{
    private const string STORAGE = 'todos.txt';

    /**
     * @var string[]
     */
    private array $todos;

    public function __construct()
    {
        $this->todos = $this->readTodos();
    }

    /**
     * @return string[]
     */
    private function readTodos(): array
    {
        if (!file_exists(self::STORAGE)) {
            return [];
        }

        $todos = file_get_contents(self::STORAGE);
        return array_filter(explode(PHP_EOL, $todos), 'trim');
    }

    /**
     * @return string[]
     */
    public function getTodos(): array
    {
        return $this->todos;
    }

    public function delete(int $key): void
    {
        if (isset($this->todos[$key])) {
            unset($this->todos[$key]);
            $this->todos = array_values($this->todos); // Reindex array
            $this->saveTodos();
        }
    }

    private function saveTodos(): void
    {
        file_put_contents(self::STORAGE, implode(PHP_EOL, $this->todos));
    }


    public function getTodo(int $key): string
    {
        return $this->todos[$key] ?? '';
    }

    public function update(int $key, string $todo): void
    {
        if (isset($this->todos[$key])) {
            $this->todos[$key] = $todo;
        }

        $this->saveTodos();
    }

    public function insert(string $todo): void
    {
        $this->todos[] = $todo;

        $this->saveTodos();
    }

}