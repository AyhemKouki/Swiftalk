<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Chat extends Component
{
    use WithFileUploads;

    public $users;
    public $selectedUser;
    public $newMessage;

    public $messages;

    public $loginID;

    public $attachment;


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

    public function removeAttachment()
    {
        $this->attachment = null;
    }

    public function submit()
    {
        // Vérifier s'il y a un message ou une pièce jointe
        if (!$this->newMessage && !$this->attachment) return;

        $messageData = [
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedUser->id,
            'message' => $this->newMessage ?: null,
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('chat-attachments', 'public');
            $messageData['attachment_path'] = $path;
            $messageData['attachment_name'] = $this->attachment->getClientOriginalName();
            $messageData['attachment_type'] = $this->attachment->getMimeType();
        }

        $message = ChatMessage::create($messageData);


        $this->messages->push($message);

        // Réinitialiser les champs
        $this->newMessage = '';
        $this->attachment = null;


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
