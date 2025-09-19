<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ApiDemo extends Component
{
    public $tasks;
    public $title;
    public $description;
    public $title_hi;
    public $description_hi;
    public $taskId;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Task::orderBy('created_at', 'desc')->get();
    }

    public function createTask()
    {
        $this->validate();

        $titleHi = $this->translateText($this->title);
        $descriptionHi = $this->description ? $this->translateText($this->description) : null;

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'translations' => [
                'hi' => [
                    'title' => $titleHi,
                    'description' => $descriptionHi,
                ],
            ],
        ]);

        $this->resetInput();
        $this->loadTasks();
        session()->flash('message', 'Task created successfully.');
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $this->taskId = $id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->title_hi = $task->translations['hi']['title'] ?? '';
        $this->description_hi = $task->translations['hi']['description'] ?? '';
        $this->isEditing = true;
    }

    public function updateTask()
    {
        $this->validate();

        if ($this->taskId) {
            $task = Task::find($this->taskId);

            $titleHi = $this->translateText($this->title);
            $descriptionHi = $this->description ? $this->translateText($this->description) : null;

            $task->update([
                'title' => $this->title,
                'description' => $this->description,
                'translations' => [
                    'hi' => [
                        'title' => $titleHi,
                        'description' => $descriptionHi,
                    ],
                ],
            ]);

            $this->resetInput();
            $this->loadTasks();
            session()->flash('message', 'Task updated successfully.');
        }
    }

    public function toggleTask($id)
    {
        $task = Task::find($id);
        $task->completed = !$task->completed;
        $task->save();
        $this->loadTasks();
    }

    public function deleteTask($id)
    {
        Task::find($id)->delete();
        $this->loadTasks();
        session()->flash('message', 'Task deleted successfully.');
    }

    private function translateText($text)
    {
        if (!$text) {
            return null;
        }

        try {
            $response = Http::withoutVerifying()->post("https://api.ptpinstitute.com/api/translator/", [
                "text" => $text,
                "source" => "en",
                "dest" => "hi"
            ]);

            return $response->json("translated");
        } catch (\Exception $e) {
            session()->flash('message', 'Translation failed: ' . $e->getMessage());
            return null;
        }
    }

    public function resetInput()
    {
        $this->title = '';
        $this->description = '';
        $this->title_hi = '';
        $this->description_hi = '';
        $this->taskId = null;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.api-demo');
    }
}
