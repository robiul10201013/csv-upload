<?php

namespace App\Livewire;

use App\Jobs\ProcessFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Auth;

class FileUploader extends Component
{
    use WithFileUploads;

    public $file;
    public function render()
    {
        return view('livewire.file-uploader');
    }

    public function save()
    {
        $this->validate([
            'file' => 'required|mimes:csv',
        ]);

        // Store Uploaded File
        $path = $this->file->storeAs('csv', $this->file->getClientOriginalName());

        // Create a databse record
        $file = FileUpload::create([
            'user_id' => Auth::id(),
            'file_name' => $this->file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        // Send File For Processing
        ProcessFile::dispatch($file);

        // Trigger a browser event with Livewire
        $this->dispatch('file-uploaded')->to(FileUploadTable::class);

        session()->flash('message', 'File uploaded successfully!');

    }
}
