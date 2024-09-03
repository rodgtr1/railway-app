<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Thumbnail;
class ShowThumbnails extends Component
{
    public $thumbnails;

    public function mount()
    {
        $userId = auth()->id();
        $this->thumbnails = Thumbnail::query()
            ->where('user_id', $userId)
            ->get();
    }

    public function render()
    {
        return view('livewire.show-thumbnails');
    }
}