<div>
    <h1 class="display-4">Group Chat</h1>
    <p class="lead mb-4">communicate with others</p>
    <hr class="my-4">


<div class="d-flex" style="height: 750px; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); background-color: white;">

<!-- Liste des groupes -->
    <div class="w-25 border-end">
        <div class="p-4 fw-bold text-dark border-bottom d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-people-fill me-2"></i>Groups
            </div>
            <button class="btn btn-link text-primary p-0" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                <i class="bi bi-plus-circle-fill fs-5"></i>
            </button>
        </div>
        <div class="overflow-auto" style="height: calc(100% - 69px);">
        @foreach($groups as $group)
                <div wire:click="selectGroup({{ $group->id }})"
                     class="p-3 border-bottom user-list-item @if($selectedGroup && $selectedGroup->id == $group->id) selected-user @endif"
                     style="cursor: pointer; transition: background-color 0.2s ease;">
                    <div class="d-flex align-items-center">
                        <div class="position-relative">
                            <img src="{{asset('images/male.jpg')}}" alt="Group Avatar" class="rounded-circle" width="40"
                                 height="40">
                        </div>
                        <div class="ms-3">
                            <div class="fw-semibold">{{ $group->name }}</div>
                            <div class="small text-muted">{{ $group->members->count() }} members</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Zone de chat -->
    <div class="w-75 d-flex flex-column">
        @if($selectedGroup)
            <!-- En-tête du groupe -->
            <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="position-relative">
                        <img src="{{asset('images/male.jpg')}}" alt="Group Avatar" class="rounded-circle" width="48"
                             height="48">
                    </div>
                    <div class="ms-3">
                        <div class="h5 fw-bold mb-0">{{ $selectedGroup->name }}</div>
                        <div class="small text-muted">{{ $selectedGroup->members->count() }} members</div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary rounded-circle" data-bs-toggle="modal"
                            data-bs-target="#addMemberModal">
                        <i class="bi bi-person-plus-fill"></i>
                    </button>
                    <button class="btn btn-outline-secondary rounded-circle" data-bs-toggle="modal"
                            data-bs-target="#membersModal">
                        <i class="bi bi-people-fill"></i>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-grow-1 p-4 overflow-auto d-flex flex-column-reverse" style="background-color: #f8f9fa;"
                 id="messages">
                @foreach($messages->reverse() as $message)
                <div class="d-flex flex-column @if($message->sender_id === $loginID) align-items-end @endif mb-3">
                        <div
                            class="px-4 py-2 rounded-4 shadow-sm @if($message->sender_id === $loginID) bg-primary text-white @else bg-white @endif"
                            style="max-width: 24rem;">
                            <div
                                class="small @if($message->sender_id === $loginID) text-white-50 @else text-muted @endif mb-1">
                                {{ $message->sender_id === $loginID ? 'You' : $message->sender->name }}
                            </div>
                            {{$message->message}}
                        </div>
                        <div class="small text-muted mt-1">
                            {{ $message->created_at->format('g:i A') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Zone de saisie -->
            <form wire:submit="submit" class="p-4 border-top d-flex align-items-center gap-3">
                <input
                    wire:model.live="newMessage"
                    type="text"
                    class="form-control rounded-pill border-0 shadow-sm px-4 py-3"
                    placeholder="Type your message..."
                    style="background-color: #f8f9fa;"
                />
                <button
                    type="submit"
                    class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                    style="width: 46px; height: 46px;"
                >
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        @else
            <div class="flex-grow-1 d-flex align-items-center justify-content-center text-muted">
                Select a group to start chatting
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('scroll-to-bottom', function () {
                const messagesDiv = document.getElementById('messages');
                if (messagesDiv) {
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }
            });
        });
    </script>

</div>

    <!-- Modal pour créer un groupe -->
    <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create new group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('groups.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Group name</label>
                            <input type="text" class="form-control" id="groupName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="groupDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="groupDescription" name="description" rows="3"></textarea>
                        </div>
<!-- Dans votre modal de création de groupe -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Membres à ajouter
    </label>
    <div class="max-h-32 overflow-y-auto border border-gray-300 rounded-md p-2">
        @php
            $availableUsers = \App\Models\User::whereNot('id', auth()->id())->get();
        @endphp

        @forelse($availableUsers as $user)
            <label class="flex items-center space-x-2 py-1">
                <input type="checkbox"
                       name="members[]"
                       value="{{ $user->id }}"
                       {{ in_array($user->id, old('members', [])) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="text-sm">{{ $user->name }} ({{ $user->email }})</span>
            </label>
        @empty
            <p class="text-sm text-gray-500">Aucun autre utilisateur disponible</p>
        @endforelse
    </div>
</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter des membres -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('groups.add-member', ['group' => $selectedGroup?->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="userId" class="form-label">Select User</label>
                            <select class="form-select" id="userId" name="user_id" required>
                                <option value="">Select a user</option>

                                @foreach(\App\Models\User::all() as $user)
                                    @if($selectedGroup && $selectedGroup->created_by !== $user->id && !$selectedGroup->members->contains($user))
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour gérer les membres -->
    <div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="membersModalLabel">Group Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        @if($selectedGroup)
                            @foreach($selectedGroup->members as $member)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <img src="{{asset('images/male.jpg')}}" alt="User Avatar"
                                             class="rounded-circle me-2" width="32" height="32">
                                        {{ $member->name }}
                                        @if($selectedGroup->isAdmin($member))
                                            <span class="badge bg-primary ms-2">Admin</span>
                                        @endif
                                    </div>
                                    @if($selectedGroup->isAdmin(auth()->user()) && $member->id !== auth()->id())
                                        <form
                                            action="{{ route('groups.remove-member', ['group' => $selectedGroup->id, 'user' => $member->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to remove this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-person-x-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
