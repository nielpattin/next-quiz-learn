<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class ManageUsers extends Component
{
    public $users;
    public $editId = null;
    public $editRole = '';
    public $editSubscription = '';
    public $editCredit = 0;

    public function mount()
    {
        $this->users = User::all();
    }

    public function startEdit($id)
    {
        $user = $this->users->find($id);
        if ($user) {
            $this->editId = $user->id;
            $this->editRole = $user->role;
            $this->editSubscription = $user->subscription;
            $this->editCredit = $user->credit;
        }
    }

    public function saveEdit()
    {
        $user = $this->users->find($this->editId);
        if ($user) {
            $user->role = $this->editRole;
            $user->subscription = $this->editSubscription;
            $user->credit = $this->editCredit;
            $user->save();
            $this->users = User::all();
        }
        $this->editId = null;
    }

    public function cancelEdit()
    {
        $this->editId = null;
    }

    public function render()
    {
        return view('livewire.admin.manage-users');
    }
}
