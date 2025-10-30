<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRole = '';

    protected $queryString = ['search', 'selectedRole'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedRole()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedRole, function ($query) {
                $query->role($this->selectedRole);
            })
            ->with('roles')
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.users.user-list', compact('users', 'roles'));
    }

    public function assignRole($userId, $roleName)
    {
        $user = User::find($userId);
        if ($user) {
            $user->syncRoles([$roleName]);
            session()->flash('message', 'Role assigned successfully!');
        }
    }

    public function toggleStatus($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['is_active' => !$user->is_active]);
            session()->flash('message', 'User status updated successfully!');
        }
    }
}
