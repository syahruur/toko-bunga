<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $name, $email, $password, $role = 'customer', $address, $phone, $user_id;
    public $isEdit = false;
    public $deleteId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'role' => 'required|in:admin,customer',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
    ];

    public function mount()
    {
        // Removed loadUsers, not needed
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->name = $this->email = $this->password = $this->address = $this->phone = null;
        $this->role = 'customer';
        $this->user_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate(array_merge($this->rules, [
            'password' => 'required|string|min:6',
        ]));
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'address' => $this->address,
            'phone' => $this->phone,
        ]);
        $this->resetForm();
        // Removed loadUsers, not needed
        LivewireAlert::title('Pengguna berhasil ditambahkan!')->success()->show();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->address = $user->address;
        $this->phone = $user->phone;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate($this->rules);
        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'address' => $this->address,
            'phone' => $this->phone,
        ]);
        $this->resetForm();
        // Removed loadUsers, not needed
        LivewireAlert::title('Pengguna berhasil diperbarui!')->success()->show();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Yakin hapus pengguna ini?',
            'text' => 'Tindakan ini tidak dapat dibatalkan.',
            'type' => 'warning',
            'confirmButtonText' => 'Hapus',
            'cancelButtonText' => 'Batal',
            'method' => 'deleteConfirmed',
        ]);
    }

    public function deleteConfirmed()
    {
        $id = $this->deleteId;
        User::findOrFail($id)->delete();
        $this->deleteId = null;
        LivewireAlert::title('Pengguna berhasil dihapus!')->success()->show();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        LivewireAlert::title('Pengguna berhasil dihapus!')->success()->show();
    }

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.users', compact('users'));
    }
}
