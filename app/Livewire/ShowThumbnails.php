<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Thumbnail;
class ShowThumbnails extends Component
{
    public $thumbnails;

    public function mount()
    {
        $userId = auth()->id(); // Get the authenticated user's ID
        $this->thumbnails = Thumbnail::query()
            ->where('user_id', $userId) // Filter by user ID
            ->get();
    }

    public function render()
    {
        return view('livewire.show-thumbnails');
    }
}