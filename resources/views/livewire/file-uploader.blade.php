<div x-data="{isUploading: false, progress: 0}"
    x-on:livewire-upload-start="isUploading=true"
    x-on:livewire-upload-finish="isUploading=false"
    x-on:livewire-upload-error="isUploading=false"
    x-on:livewire-upload-progress="progress=$event.detail.progress">

    @if (session('message'))
        <div class="bg-green-200 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <div class="bg-red-200 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ $error }}</p>
                </div>
                @endforeach
        </div>
    @endif


    <div class="pb-10 flex items-center justify-center w-full">
        <label for="dropzone-file"
            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                        upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">CSV Only (MAX. 100MB)</p>
            </div>
            <input wire:model="file" id="dropzone-file" type="file" class="hidden" wire:change.debounce.500ms="save($event.target.files)" />
        </label>
    </div>

    <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
        <div class="bg-indigo-600 h-2.5 rounded-full dark:bg-indigo-500" x-bind:style="`width: ${progress}%`"></div>
    </div>

</div>
