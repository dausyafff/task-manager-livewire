<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TaskManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $title = '';
    public $search = '';
    public $editingTaskId = null;
    public $editingTaskTitle = '';

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    }

    public function saveTask()
    {
        $this->validate([
            'title' => 'required|min:3',
        ]);

        Task::create([
            'title' => $this->title,
            'completed' => false,
            'user_id' => auth()->id(),
        ]);

        $this->title = '';

        session()->flash('message', 'Task created successfully!');
    }

    public function editTask($taskId)
    {
        $task = Task::where('user_id', auth()->id())
            ->findOrFail($taskId);

        $this->editingTaskId = $task->id;
        $this->editingTaskTitle = $task->title;
    }

    public function updateTask()
    {
        $this->validate([
            'editingTaskTitle' => 'required|min:3',
        ]);

        $task = Task::where('user_id', auth()->id())
            ->findOrFail($this->editingTaskId);

        $task->update([
            'title' => $this->editingTaskTitle,
        ]);

        $this->editingTaskId = null;
        $this->editingTaskTitle = '';

        session()->flash('success', 'Task berhasil diperbarui');
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->editingTaskTitle = '';
    }

    public function deleteTask($taskId)
    {
        $task = Task::where('user_id', auth()->id())
            ->findOrFail($taskId);

        $task->delete();

        session()->flash('message', 'Task deleted successfully!');
    }

    public function toggleTask($taskId)
    {
        $task = Task::where('user_id', auth()->id())
            ->findOrFail($taskId);

        $task->completed = !$task->completed;
        $task->save();

        session()->flash('message', 'Task status updated successfully!');
    }

    public function render()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where(
                    'title',
                    'like',
                    "%{$this->search}%"
                );
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('livewire.task-manager', compact('tasks'));
    }
}
