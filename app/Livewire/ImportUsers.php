<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // <-- Ye zaruri hai
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\Import;

class ImportUsers extends Component
{
    use WithFileUploads; // <-- file uploads enable karne ke liye

    public $file;
    public $import;

    public function upload()
    {
        $this->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        // File ko temporary storage me save karna
        $path = $this->file->store('temp');

        // Import record create
        $import = Import::create([
            'user_id' => Auth::user()->id,
            'file' => $path,
            'status' => 'pending',
            'duplicate_action' => 'skip'
        ]);

        // Dispatch Queue Job
        \App\Jobs\ProcessUserImportJob::dispatch($import->id);

        $this->import = $import;
    }

    public function render()
    {
        return view('livewire.import-users');
    }
}