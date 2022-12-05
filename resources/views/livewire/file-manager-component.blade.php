<div>
    <div>
        <x-full-page-loader wire:loading.delay />
    </div>
    <!-- <div>
        Selected: {{ json_encode($selectedFiles) }} <br>
        Files: {{ json_encode($files) }} <br>
    </div> -->
    <div class="container-fluid">
        <div class="container-m-nx container-m-ny bg-lightest mb-3">
           <div>
             <ol class="breadcrumb text-big container-p-x py-3 m-0">
                <li class="breadcrumb-item">
                    <a wire:click.prevent="setCurrentDir()" id="brd-1">Home</a>
                </li>
                @foreach(explode('/',$currentDir) as $key=>$dir)
                        @if($loop->last)
                        <li class="breadcrumb-item active" id="b-last">{{ $dir }}</li>
                        @else
                        <li class="breadcrumb-item">
                            <a wire:click.prevent="setCurrentDir('{{ $dir }}')" id="bir{{ $key }}">{{ $dir }}</a>
                        </li>
                        @endif
                @endforeach
            </ol>
           </div>

            <hr class="m-0" />

            <div class="py-2 d-flex justify-content-between align-items-center">
                <div>
                    <!-- @can('files-upload')
                    <button type="button" class="btn btn-primary mr-2 d-none" data-bs-toggle="modal" data-bs-target="#modal-upload-files"><i class="fas fa-upload"></i>&nbsp; Upload</button>
                    @endcan
                    @can('folder-create')
                    <button type="button" class="btn btn-primary mr-2" wire:click.prevent="$emit('newDir')"><i class="fas fa-add"></i>&nbsp; New Folder</button>
                    @endcan
                    @can('files-copy-and-cut')
                    <button type="button" class="btn btn-primary mr-2" wire:click.prevent="copyFiles" {{ $selectedMode=='copy' || $selectedFiles==[] ? 'disabled':'' }} id="copy-selected-btn">Copy</button>
                    <button type="button" class="btn btn-primary mr-2" wire:click.prevent="cutFiles" {{ $selectedMode=='cut' || $selectedFiles==[] ? 'disabled':'' }} id="cut-selected-btn">Cut</button>
                    <button type="button" class="btn btn-primary mr-2" wire:click.prevent="pasteFiles" {{ $selectedFiles==[] || !$selectedMode ? 'disabled':'' }}>Paste Here</button>
                    @endcan
                    @can('files-delete')
                    <button type="button" class="btn btn-danger mr-2" wire:click.prevent="$emit('confirmDeleteSelected')" {{ $selectedFiles==[]  ? 'disabled':'' }} id="delete-selected-btn">Delete Selected</button>
                    @endcan -->
                    <button type="button" title="Refresh" class="btn btn-info icon-btn mr-2" wire:click.prevent="refresh"><i class="fas fa-refresh"></i></button>
                </div>
                <div>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>  
                        </span>
                        <input type="text" class="form-control" id="search-current-folder-input" placeholder="Search in Current Folder" aria-label="Search">
                    </div>
                </div>
            </div>

            <hr class="m-0" />
        </div>

        <div class="row m-0 gy-2">

            @foreach($directories as $key=>$tdirectory)
            @php
                $directory=str_contains($tdirectory, '/') ? substr($tdirectory, strrpos($tdirectory, '/') + 1):$tdirectory;
            @endphp
            <div class="col-2 p-0 searchable-parent" id="dir-{{ $key }}">
                <div class="bg-white p-2 m-1 h-100">
                    <div class="align-items-center d-flex justify-content-end">
                        <div class="form-check d-none">
                            <input class="form-check-input select-file-check" wire:model.defer="selectedFiles" type="checkbox" value="{{ $tdirectory }}" id="defaultCheck{{ $key }}">
                            <label class="form-check-label" for="defaultCheck{{ $key }}"></label>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-toggle" type="button" id="dir-dropdown{{ $key }}" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dir-dropdown{{ $key }}">
                                    <!-- <li><a class="dropdown-item" href="#">Copy</a></li>
                                    <li><a class="dropdown-item" href="#">Cut</a></li> -->
                                    <!-- <li><a class="dropdown-item" wire:click.prevent="$emit('renameDir','{{ $directory }}')">Rename</a></li> -->
                                    @can('folder-delete')
                                  <li><a class="dropdown-item text-danger" wire:click.prevent="$emit('confirmDeleteDir','{{ $directory }}')">Delete</a></li>
                                  @endcan
                                </ul>
                              </div>
                        </div>
                    </div>
                    <a wire:click.prevent="setCurrentDir('{{ ($currentDir ? $currentDir.'/':'').$directory }}')">
                        <div class="align-items-center d-flex flex-column justify-content-center">
                            <i class="far fa-folder text-secondary fa-3x"></i>
                            <p class="mb-0 mt-2 searchable-text">{{ $directory }}</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            @foreach($files as $key=>$tfile)
            @php
                $file=str_contains($tfile, '/') ? substr($tfile, strrpos($tfile, '/') + 1):$tfile;
            @endphp
            <div class="col-2 p-0 searchable-parent" id="fl-{{ $key }}">
                <div class="bg-white p-2 m-1 h-100">
                    <div class="align-items-center d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input select-file-check" wire:model.defer="selectedFiles" type="checkbox" value="{{ $tfile }}" id="file-check{{ $key }}">
                            <label class="form-check-label" for="file-check{{ $key }}"></label>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-toggle" type="button" id="file-dropdown{{ $key }}" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="file-dropdown{{ $key }}">
                                    <!-- <li><a class="dropdown-item" href="#">Copy</a></li>
                                    <li><a class="dropdown-item" href="#">Cut</a></li> -->
                                    @can('files-rename')
                                    <li><a class="dropdown-item" wire:click.prevent="$emit('renameFile','{{ $file }}')">Rename</a></li>
                                    @endcan
                                    @can('files-download')
                                    <li><a class="dropdown-item" wire:click.prevent="downloadFile('{{ $tfile }}')">Download</a></li>
                                    @endcan
                                    @can('files-delete')
                                  <li><a class="dropdown-item text-danger" wire:click.prevent="$emit('confirmDeleteFile','{{ $file }}')">Delete</a></li>
                                  @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div >
                        <div class="align-items-center d-flex flex-column justify-content-center">
                            <i class="far fa-file-alt text-muted fa-3x"></i>
                            <p class="mb-0 mt-2 text-center searchable-text" style="font-size: 0.8em;">{{ $file }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Upload Files Modal Content -->
    <div wire:ignore.self class="modal fade" id="modal-upload-files" tabindex="-1" role="dialog" aria-labelledby="modal-upload-files" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="btn-close btn-close-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-3">
                    
                    <div>
                        <x-filepond-input wire:model="filesToUpload" multiple allowImagePreview imagePreviewMaxHeight="200" allowFileTypeValidation acceptedFileTypes="['image/*']" allowFileSizeValidation maxFileSize="4mb" />
                    </div>
                    
                </div>
                <div class="modal-footer z-2 mx-auto text-center">
                    <p class="text-white font-small"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Upload Files Modal Content -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {  
            
            $(document).ready(function(){

                $("#search-current-folder-input").on("keyup", function(e) {
                    e.preventDefault();
                    var value = $(this).val().toLowerCase();
                    $(".searchable-parent .searchable-text").filter(function() {
                        $(this).parents('.searchable-parent').toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });

                $(document).on("change",".select-file-check",function(e) {
                    if($('.select-file-check:checkbox:checked').length>0)
                    {
                        $('#delete-selected-btn').attr('disabled',false);
                        $('#copy-selected-btn').attr('disabled',false);
                        $('#cut-selected-btn').attr('disabled',false);
                    }else{
                        $('#delete-selected-btn').attr('disabled',true);
                        $('#copy-selected-btn').attr('disabled',true);
                        $('#cut-selected-btn').attr('disabled',true);
                    }
                });

              });
            
            @this.on('confirmDeleteDir', dir => {

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
                        @this.call('deleteDir', dir)
                    }
                })

            });

            @this.on('confirmDeleteFile', file => {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteFile', file)
                    }
                })

            });

            @this.on('newDir', async fn => {

                var { value: newDir } =await Swal.fire({
                    title: 'Enter Folder Name',
                    input: 'text',
                    showCancelButton: true,
                    inputPlaceholder: 'Enter New Name',
                    inputValidator: (value) => {
                        if (!value) {
                          return 'You need to choose something!'
                        }
                      }
                  })
                  
                  if (newDir) {
                    @this.call('createNewDir',newDir)
                  }

            });

            //@this.on('renameDir', async oldName => {
//
            //    var { value: newName } =await Swal.fire({
            //        title: 'Rename Folder',
            //        input: 'text',
            //        inputValue: oldName,
            //        inputPlaceholder: 'Enter New Name',
            //        inputValidator: (value) => {
            //            if (!value) {
            //              return 'You need to choose something!'
            //            }
            //          }
            //      })
            //      
            //      if (newName && oldName != newName) {
            //        @this.call('renameDir',oldName,newName)
            //      }
            //      else if(oldName == newName){
            //        Swal.fire({
            //            icon:"error",
            //            text:"New and Old Name is Same",
            //        })
            //      }
//
            //});

            @this.on('renameFile', async oldName => {

                var { value: newName } =await Swal.fire({
                    title: 'Rename File',
                    input: 'text',
                    showCancelButton: true,
                    inputValue: oldName,
                    inputPlaceholder: 'Enter New Name',
                    inputValidator: (value) => {
                        if (!value) {
                          return 'You need to choose something!'
                        }
                      }
                  })
                  
                  if (newName && oldName != newName) {
                    @this.call('rename',oldName,newName)
                  }
                  else if(oldName == newName){
                    Swal.fire({
                        icon:"error",
                        text:"New and Old Name is Same",
                    })
                  }

            });

            @this.on('confirmDeleteSelected', file => {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete All Selcted Files!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteSelectedFiles')
                    }
                })

            });

        });
    </script>
</div>
