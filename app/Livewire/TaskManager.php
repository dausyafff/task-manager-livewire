<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class TaskManager extends Component
{
    use WithPagination;
    protected $listeners = ["deleteTask", "toggleTask"];
    protected $paginationTheme = 'bootstrap';
    public $title = "", $search = "", $editingTaskId = null, $editingTaskTitle = "";
    public function saveTask()
    {
        $this->validate([
            'title' => 'required|min:3',
        ]);
        Task::create([
            'title' => $this->title,
            "completed" => false
        ]);

        $this->title = "";
        session()->flash('message', 'Task created successfully!');
    }

    public function editTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->editingTaskId = $taskId;
        $this->editingTaskTitle = $task->title;
    }

    public function updateTask()
    {
        $this->validate([
            "editingTaskTitle" => 'required|min:3',
        ]);

        Task::find($this->editingTaskId)->update([
            'title' => $this->editingTaskTitle,
        ]);

        $this->editingTaskId = null;
        $this->editingTaskTitle = "";
        session()->flash('success', 'Task berhasil diperbarui');
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->editingTaskTitle = "";
    }

    public function deleteTask($taskId)
    {
        Task::findOrFail($taskId)->delete();
        session()->flash('message', 'Task deleted successfully!');
    }

    public function toggleTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->completed = !$task->completed;
        $task->save();
        session()->flash('message', 'Task status updated successfully!');
    }

    public function render()
    {
        $tasks = Task::when($this->search, function ($query) {
            return $query->where("title", "like", "%{$this->search}%");
        })->latest()->paginate(5)->withQueryString();
        return view('livewire.task-manager', compact('tasks'));
    }
    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->to('/login');
        }
    }
    public function fetchData()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('token'),
            'Accept' => 'application/json',
        ])->get(config('app.url') . '/api/user');

        if ($response->successful()) {
            $this->user = $response->json();
        } else {
            session()->flash('error', 'Failed to fetch user data');
        }
    }
}
