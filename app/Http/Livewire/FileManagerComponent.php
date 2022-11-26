<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileManagerComponent extends Component
{
    use WithFileUploads;
    public $files=[];
    public $directories=[];
    public $currentDir;
    public $newDirName;
    public $selectedFiles=[];
    public $selectedMode;
    public $filesToUpload=[];

    protected $queryString = ['currentDir'];    

    public function mount()
    {
        $this->getFiles();
    }

    public function refresh()
    {
        $this->getFiles();
    }

    public function getCurrentDir()
    {
        return $this->currentDir ? $this->currentDir.'/':'';
    }
    
    public function setCurrentDir($path=null)
    {
        $this->currentDir=$path;
        if(!$this->selectedMode)
        {
            $this->selectedFiles=[];
        }
        $this->getFiles();
    }

    public function createNewDir($newDirName)
    {
        try {
            Storage::disk('s3')->makeDirectory($this->getCurrentDir().$newDirName);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }
        $this->getFiles();
        $this->dispatchBrowserEvent('success-notification',['message'=>'New Floder Created']);
    }

    public function deleteDir($dir)
    {
        try {
            Storage::disk('s3')->deleteDirectory($this->getCurrentDir().$dir);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }
        $this->getFiles();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Floder Deleted']);
    }

    public function deleteFile($file)
    {
        try {
        Storage::disk('s3')->delete($this->getCurrentDir().$file);  
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }
        $this->getFiles();
        $this->dispatchBrowserEvent('success-notification',['message'=>'File Deleted '.$file]);
    }

    public function deleteSelectedFiles()
    {
        try {
        Storage::disk('s3')->delete($this->selectedFiles);  
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }
        $this->getFiles();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Selected Files Deleted ']);
    }

    public function rename($oldName,$newName)
    {
        try {
            Storage::disk('s3')->move($this->getCurrentDir().$oldName,$this->getCurrentDir().$newName);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }
        $this->getFiles();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Renamed']);
    }

    // public function renameDir($oldName,$newName)
    // {
    //     try {
    //         $d_files=Storage::disk('s3')->files($this->getCurrentDir().$oldName);
    //         foreach($d_files as $file)
    //         {
    //             Storage::disk('s3')->move($file,$this->getCurrentDir().$newName.'/'.$this->getLastSplit($file));
    //         }
    //         if(count($d_files)<1)
    //         {
    //             Storage::disk('s3')->deleteDirectory($this->getCurrentDir().$oldName);
    //             Storage::disk('s3')->makeDirectory($this->getCurrentDir().$newName);
    //         }
    //     } catch (\Exception $e) {
    //         $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
    //         return 1;
    //     }
    //     $this->getFiles();
    //     $this->dispatchBrowserEvent('success-notification',['message'=>'Renamed']);
    // }

    public function copyFiles()
    {
        $this->selectedMode='copy';
    }

    public function cutFiles()
    {
        $this->selectedMode='cut';
    }

    public function pasteFiles()
    {
        try {          
                if($this->selectedMode=='copy')
                {
                    foreach($this->selectedFiles as $file)
                    {
                        Storage::disk('s3')->copy($file,$this->getCurrentDir().$this->getLastSplit($file));
                    }
                }elseif($this->selectedMode=='cut')
                {
                    foreach($this->selectedFiles as $file)
                    {
                        Storage::disk('s3')->move($file,$this->getCurrentDir().$this->getLastSplit($file));
                    }
                }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }

        $this->selectedMode=null;
        $this->selectedFiles=[];
        $this->getFiles();
        $this->dispatchBrowserEvent('success-notification',['message'=>'Files'.$this->selectedMode=='copy' ? 'Copied':'Moved'. 'Successfully']);
    }

    public function getFiles()
    {
        try {
            $this->directories=Storage::disk('s3')->directories($this->currentDir);
            $this->files=Storage::disk('s3')->files($this->currentDir);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error-prompt',['message'=>$e->getMessage()]);
            return 1;
        }
    }

    public function getLastSplit($path)
    {
        return str_contains($path, '/') ? substr($path, strrpos($path, '/') + 1):$path;
    }

    public function render()
    {
        return view('livewire.file-manager-component');
    }
}
