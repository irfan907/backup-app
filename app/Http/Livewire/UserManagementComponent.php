<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagementComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public User $user;
    public $editableMode=false;

    protected $rules=[
        'user.name'=>'required',
        'user.email'=>'required',
        'user.password'=>'nullable',
        
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
        }
        else{
            $this->user=new User();
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
        $this->user->save();
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
