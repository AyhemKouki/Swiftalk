<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GroupChat extends Component
{
    public $groups;
    public $selectedGroup;
    public $newMessage;
    public $messages;
    public $loginID;

    public function mount()
    {
        $this->groups = auth()->user()->groups;
        $this->selectedGroup = $this->groups->first();
        $this->loadMessages();
        $this->loginID = auth()->id();
    }

    public function selectGroup($groupId)
    {
        $this->selectedGroup = Group::find($groupId);
        $this->loadMessages();
        $this->dispatch('scroll-to-bottom');
    }

    public function loadMessages()
    {
        if ($this->selectedGroup) {
            $this->messages = ChatMessage::where('group_id', $this->selectedGroup->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        $this->dispatch('scroll-to-bottom');
    }

    public function submit()
    {
        if (!$this->newMessage || !$this->selectedGroup) return;

        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'group_id' => $this->selectedGroup->id,
            'message' => $this->newMessage,
            'message_type' => 'group'
        ]);

        $this->messages->push($message->load('sender'));
        $this->newMessage = '';
        $this->dispatch('scroll-to-bottom');

        broadcast(new MessageSent($message));
    }

    public function getListeners()
    {
        $listeners = [];

        // Écouter les messages de tous les groupes dont l'utilisateur fait partie
        foreach ($this->groups as $group) {
            $listeners["echo-private:group.{$group->id},MessageSent"] = "newGroupMessageNotification";
        }

        return $listeners;
    }

    public function newGroupMessageNotification($message): void
    {
        if ($this->selectedGroup && $message['group_id'] == $this->selectedGroup->id) {
            $messageObj = ChatMessage::with('sender')->find($message['id']);
            $this->messages->push($messageObj);
            $this->dispatch('scroll-to-bottom');
        }
    }

    public function render()
    {
        return view('livewire.group-chat');
    }
}
