<div class="card card-custom gutter-b example example-compact">
    <div class="card-body pt-1">
        <div style="min-height: 20px;"><span class="text-sm text-info" wire:loading><i class="fas fa-spinner fa-spin text-info"></i> Loading..</span></div>
        @if($editableMode)
            <form wire:submit.prevent="save">
                <h2 class="text-capitalize">user Details</h2>
                <div class="row gutters-0 mt-3">

                    <div class="form-group col-md-12">
                        <label>name</label>
                        <input wire:model.defer="user.name" type="text" class="form-control @error('user.name') border border-danger @enderror">
                        @error('user.name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label>email</label>
                        <input wire:model.defer="user.email" type="text" class="form-control @error('user.email') border border-danger @enderror">
                        @error('user.email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label>password</label>
                        <input wire:model.defer="user.password" type="text" class="form-control @error('user.password') border border-danger @enderror">
                        @error('user.password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-md-12 mt-2">
                        <button type="submit" class="btn btn-tertiary font-weight-bolder btn-sm">Save</button>
                        <button wire:click.prevent="cancelEdit" class="btn btn-secondary font-weight-bolder btn-sm">Cancel</button>
                    </div>

                </div>
            </form> 
        @else
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-capitalize">users</h2>
            <a href="" wire:click.prevent="createOrEdit" class="btn btn-tertiary font-weight-bolder btn-sm my-2 text-capitalize">Add New user</a>
        </div>

        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Time</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td> 
                        <td>{{ $user->created_at->format('d-M-Y h:i a') }}</td>
                        <td>
                            <button wire:click.prevent="createOrEdit({{ $user->id }})" class="btn btn-sm btn-info">Edit</button>
                            <button wire:click.prevent="$emit('confirmDelete',{{ $user->id }})" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100">
                            <div class="alert alert-secondary text-center">No users Data Found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $users->links() }}
        </div>
        @endif


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