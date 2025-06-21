<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\User;
use Livewire\Component;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage;

    public $messages;

    public function mount()
    {
        $this->users = User::whereNot('id', auth()->id())->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = ChatMessage::where(function ($query) {
            $query->where('sender_id', auth()->user()->id)
                ->where('receiver_id', $this->selectedUser->id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->selectedUser->id)
                ->where('receiver_id', auth()->user()->id);
        })->get();
    }

    public function submit()
    {
        // if you click on the empty then do nothing
        if (!$this->newMessage) return ;

        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->newMessage,
        ]);

        $this->messages->push($message);

        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
