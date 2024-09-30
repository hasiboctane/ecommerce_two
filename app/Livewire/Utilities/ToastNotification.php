<?php

namespace App\Livewire\Utilities;

use Livewire\Attributes\On;
use Livewire\Component;

class ToastNotification extends Component
{
    public $message = '';
    public $type = 'info';
    public $show = false;

    #[On('show-toast')]
    public function showToast($message, $type = 'info')
    {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;

        $this->dispatch('toast-shown');
    }

    public function render()
    {
        return view('livewire.utilities.toast-notification');
    }
}
