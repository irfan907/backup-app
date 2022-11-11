<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RoleManagementComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Role $role;
    public $editableMode=false;

    protected $rules=[
        'role.name'=>'required',        
        ];

    public function mount()
    {
        $this->role=new Role();
    }

    public function createOrEdit($id=null)
    {
        if($id)
        {
            $this->role=Role::find($id);
        }
        else{
            $this->role=new Role();
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
        $this->role->save();
        $this->editableMode=false;
        $this->dispatchBrowserEvent('success-notification',['message'=>'Role saved successfully.']);
    }

    public function delete($id)
    {
        Role::destroy($id);
        $this->dispatchBrowserEvent('success-notification',['message'=>'Role deleted successfully.']);
    }

    public function render()
    {
        return view('livewire.role-management-component',['roles'=>Role::latest()->paginate(10)]);
    }
}
