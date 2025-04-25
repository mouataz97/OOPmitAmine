<?php
declare(strict_types=1);

class TodoStorage
{
    private const string STORAGE = 'todos.csv';

    /**
     * @var array
     */
    private array $todos;

    public function __construct()
    {
        $this->todos = $this->readTodos();
    }

    private function readTodos(): array
    {
        if (!file_exists(self::STORAGE)) {
            return [];
        }

        $todos = [];
        if (($handle = fopen(self::STORAGE, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $todos[] = [
                    'description' => $data[0],
                    'priority' => $data[1],
                    'date' => $data[2]
                ];
            }
            fclose($handle);
        }
        return $todos;
    }

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
        if (($handle = fopen(self::STORAGE, 'w')) !== false) {
            foreach ($this->todos as $todo) {
                fputcsv($handle, $todo);
            }
            fclose($handle);
        }
    }

    public function getTodo(int $key): array
    {
        return $this->todos[$key] ?? [];
    }

    public function update(int $key, array $todo): void
    {
        if (isset($this->todos[$key])) {
            $this->todos[$key] = TodoStorage::createTodoFromPost();
            $this->saveTodos();
        }
    }

    public function insert(array $todo): void
    {
        $this->todos[] = TodoStorage::createTodoFromPost();
        $this->saveTodos();
    }

    public static function createTodoFromPost(): array
    {
        $description = $_POST['todo'] ?? '';
        $priority = $_POST['priority'] ?? 'Low';
        $date = $_POST['date'] ?? '';
        return ['description' => $description, 'priority' => $priority, 'date' => $date];
    }


}
