<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserManagementComponent extends Component
{
    use WithPagination,AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    public User $user;
    public $password;
    public $allRoles=[];
    public $selectedRole;
    public $editableMode=false;
    public bool $isNewUser=false;

    protected $rules=[
        'user.name'=>'required',
        'user.email'=>'required',
        'password'=>'nullable',
        ];

    public function mount()
    {
        $this->user=new User();
        $this->allRoles=Role::all();
    }

    public function createOrEdit($id=null)
    {
        $this->selectedRole=null;
        if($id)
        {
            $this->user=User::find($id);
            $this->isNewUser=false;
            $this->selectedRole=$this->user->getRoleNames()->first();
        }
        else{
            $this->user=new User();
            $this->isNewUser=true;
        }
        $this->editableMode=true;
    }

    public function cancelEdit()
    {
        $this->editableMode=false;
    }

    public function save()
    {
        $this->validate();
        if($this->isNewUser){
            $this->authorize('users-add');
            $this->user->password=Hash::make($this->password);
            $this->user->save();
        }else{
            $this->authorize('users-edit');
            $this->user->save();
        }
        $this->user->syncRoles($this->selectedRole);
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'User saved successfully.']);
    }

    public function delete($id)
    {
        $this->authorize('users-delete');
        User::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'User deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.user-management-component',['users'=>User::latest()->paginate(10)]);
    }
}
