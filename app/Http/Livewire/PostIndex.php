<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PostIndex extends Component
{   
    public $showingPostModal = false;

    public function showPostModal()
    {
        $this->showingPostModal = true;
        
    }

    public function render()
    {
        return view('livewire.post-index');
    }
}
