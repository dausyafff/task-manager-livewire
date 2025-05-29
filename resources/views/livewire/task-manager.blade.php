<div class="card shadow">

    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Task Manager</h3>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif
        <form wire:submit.prevent="saveTask" class="mb-4">
            <div class="input-group">
                <input type="text" wire:model="title" class="form-control" placeholder="Tambahkan Task Baru"
                    required>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </form>

        <div class="mb-4">
            <input type="text" wire:model.live="search" class="form-control" placeholder="Cari Task...">
        </div>

        {{-- DAFTAR TASK --}}
        <div class="list-group mb-4">
            @forelse ($tasks as $task)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" wire:click="toggleTask({{ $task->id }})" class="form-check-input"
                                {{ $task->completed ? 'checked' : '' }}>
                            @if ($editingTaskId === $task->id)
                                <input type="text" wire:model="editingTaskTitle"
                                    class="form-control form-control-sm d-inline-block w-auto">

                                @error('editingTaskTitle')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            @else
                                <label
                                    class="form-check-label{{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                                    {{ $task->title }} </label>
                            @endif
                        </div>
                        <div class="btn-group">
                            @if ($editingTaskId === $task->id)
                                <button wire:click="updateTask" class="btn btn-sm btn-success">Simpan</button>
                                <button wire:click="cancelEdit" class="btn btn-sm btn-secondary">Batal</button>
                            @else
                                <button wire:click="editTask({{ $task->id }})"
                                    class="btn btn-sm btn-warning">Edit</button>
                                <button onclick="confirmDelete({{ $task->id }})"
                                    class="btn btn-sm btn-danger">Hapus</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="list-group-item text-center text-muted">
                    Tidak ada task ditemukan.
                </div>
            @endforelse
        </div>
        {{ $tasks->links() }}
    </div>

</div>
<!-- SweetAlert untuk Konfirmasi Hapus -->
<script>
    function confirmDelete(taskId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteTask', {
                    taskId: taskId
                });
                Swal.fire(
                    'Dihapus!',
                    'Task berhasil dihapus.',
                    'success'
                );
            }
        });
    }
</script>
