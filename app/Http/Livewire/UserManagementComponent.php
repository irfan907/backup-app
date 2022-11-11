<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagementComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public User $user;
    public $password;
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
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->user=User::find($id);
            $this->isNewUser=false;
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
            $this->user->password=Hash::make($this->password);
            $this->user->save();
        }else{
            $this->user->save();
        }
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'User saved successfully.']);
    }

    public function delete($id)
    {
        User::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'User deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.user-management-component',['users'=>User::latest()->paginate(10)]);
    }
}
