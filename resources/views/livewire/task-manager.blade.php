@extends('layouts.app')
@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @elseif (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1>Todo List</h1>
        <div class="mb-3">
            <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Search tasks...">
        </div>

        @if ($editingTaskId)
            <form wire:submit.prevent="updateTask" class="mb-3">
                <div class="mb-3">
                    <input type="text" wire:model="editingTaskTitle" class="form-control" placeholder="Edit task">
                    @error('editingTaskTitle')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" wire:click="cancelEdit" class="btn btn-secondary">Cancel</button>
            </form>
        @else
            <form wire:submit.prevent="saveTask" class="mb-3">
                <div class="mb-3">
                    <input type="text" wire:model="title" class="form-control" placeholder="New task">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        @endif

        <ul class="list-group">
            @forelse ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="{{ $task->completed ? 'text-decoration-line-through' : '' }}">{{ $task->title }}</span>
                    <div>
                        <button wire:click="editTask({{ $task->id }})" class="btn btn-warning btn-sm me-2">Edit</button>
                        <button wire:click="toggleTask({{ $task->id }})" class="btn btn-info btn-sm me-2">
                            {{ $task->completed ? 'Undo' : 'Complete' }}
                        </button>
                        <button wire:click="deleteTask({{ $task->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </li>
            @empty
                <li class="list-group-item">No tasks found.</li>
            @endforelse
        </ul>
        {{ $tasks->links() }}
    </div>
@endsection
