<?php

namespace App\Livewire;

use App\Models\FileUpload;
use Livewire\Component;
use Livewire\Attributes\On;

class FileUploadTable extends Component
{
    #[On('file-uploaded')]
    public function render()
    {
        $fileUploads = FileUpload::all();
        return view('livewire.file-upload-table', ['fileUploads' => $fileUploads]);
    }
}
