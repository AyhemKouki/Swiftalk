<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage;

    public $messages;

    public $loginID;

    public function mount()
    {
        $this->users = User::whereNot('id', auth()->id())->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();
        $this->loginID = auth()->id();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
        $this->dispatch('scroll-to-bottom');
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

        $this->dispatch('scroll-to-bottom');
    }


    public function updatedNewMessage($value)
    {
        // This will be called whenever messages are updated
        $this->dispatch('scroll-to-bottom');

        $this->dispatch('userTyping', userID: $this->loginID , userName: Auth::user()->name  , selectedUserID: $this->selectedUser->id);
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

        // Dispatch event to scroll to bottom
        $this->dispatch('scroll-to-bottom');

        broadcast(new MessageSent($message));
    }

    public function getListeners()
    {
        return [
            "echo-private:chat.{$this->loginID},MessageSent" => "newChatMessageNotification"
        ];
    }
    public function newChatMessageNotification($message): void
    {

        if ($message['sender_id'] == $this->selectedUser->id) {

            $messageObj = ChatMessage::find($message['id']);
            $this->messages->push($messageObj);
            $this->dispatch('scroll-to-bottom');
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
