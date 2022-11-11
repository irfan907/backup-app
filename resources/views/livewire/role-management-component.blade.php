<div class="card card-custom gutter-b example example-compact">
    <div class="card-body pt-3">
        <x-full-page-loader wire:loading.delay />
        <div>
            @if($editableMode)
                <form wire:submit.prevent="save">
                    <h2 class="text-capitalize">role Details</h2>
                    <div class="row gutters-0 mt-3">

                        <div class="form-group col-md-12">
                            <label>Name</label>
                            <input wire:model.defer="role.name" type="text" class="form-control @error('role.name') is-invalid @enderror">
                            @error('role.name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-md-12 my-5">
                            <h4>Permissions</h4>
                            @foreach($allPermissions as $permission)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" wire:model.defer="selectedPermissions" value="{{ $permission->id }}" id="check-p-{{ $permission->id }}">
                                <label class="form-check-label" for="check-p-{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>


                        <div class="form-group col-md-12 mt-2">
                            <button type="submit" class="btn btn-tertiary font-weight-bolder btn-sm">Save</button>
                            <button wire:click.prevent="cancelEdit" class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                        </div>

                    </div>
                </form> 
            @else
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-capitalize">roles</h2>
                    <a href="" wire:click.prevent="createOrEdit" class="btn btn-tertiary font-weight-bolder btn-sm my-2 text-capitalize">Add New role</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->created_at->format('d-M-Y h:i a') }}</td>
                                <td>
                                    <button wire:click.prevent="createOrEdit({{ $role->id }})" class="btn btn-sm btn-info">Edit</button>
                                    <button wire:click.prevent="$emit('confirmDelete',{{ $role->id }})" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100">
                                    <div class="alert alert-secondary text-center">No roles Data Found</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $roles->links() }}
                </div>
            @endif
        </div>


    </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('confirmDelete', id => {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete', id)
                    }
                })

            });

        })
    </script>
</div>