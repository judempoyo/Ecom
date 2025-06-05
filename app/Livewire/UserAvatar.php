<?php

namespace App\Livewire;

use Livewire\Component;

class UserAvatar extends Component
{
    public $user;
    public $size = 'md'; // sm, md, lg
    
    public function render()
    {
        return view('livewire.user-avatar');
    }
}