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
                            <img
                                src="{{ $group->image ? asset('storage/' . $group->image) : asset('images/male.jpg') }}"
                                alt="Group Avatar" class="rounded-circle" width="40" height="40">
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
                        <img
                            src="{{ $selectedGroup->image ? asset('storage/' . $selectedGroup->image) : asset('images/male.jpg') }}"
                            alt="Group Avatar" class="rounded-circle" width="48" height="48">
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
                    @if($selectedGroup && $selectedGroup->isAdmin(auth()->user()))
                        <button class="btn btn-outline-info rounded-circle" data-bs-toggle="modal"
                                data-bs-target="#editGroupModal">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    @endif
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
            <form action="{{ route('groups.create') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="mb-3">
                        <label for="groupImage" class="form-label">Group Image</label>
                        <input type="file" class="form-control" id="groupImage" name="group_image" accept="image/*">
                        <div class="mt-2">
                            <div id="imagePreview" class="d-none">
                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Membres à ajouter</label>
                        <div style="max-height: 200px; overflow-y: auto;" class="border rounded p-2">
                            @php
                                $availableUsers = \App\Models\User::whereNot('id', auth()->id())->get();
                            @endphp

                            @forelse($availableUsers as $user)
                                <div class="form-check py-1">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="members[]"
                                           value="{{ $user->id }}"
                                           id="member_{{ $user->id }}">
                                    <label class="form-check-label" for="member_{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </label>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Aucun autre utilisateur disponible</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groupImageInput = document.getElementById('groupImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = imagePreview.querySelector('img');

        if (groupImageInput) {
            groupImageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.classList.add('d-none');
                }
            });
        }
    });
</script>

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

    <!-- Modal pour éditer un groupe -->
    <div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGroupModalLabel">Edit Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if($selectedGroup)
                    <form action="{{ route('groups.update', ['group' => $selectedGroup->id]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editGroupName" class="form-label">Group name</label>
                                <input type="text" class="form-control" id="editGroupName" name="name"
                                       value="{{ $selectedGroup->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editGroupDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editGroupDescription" name="description"
                                          rows="3">{{ $selectedGroup->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editGroupImage" class="form-label">Group Image</label>
                                <input type="file" class="form-control" id="editGroupImage" name="group_image"
                                       accept="image/*">
                                @if($selectedGroup->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $selectedGroup->image) }}"
                                             alt="Current group image" class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                    <form action="{{ route('groups.destroy', ['group' => $selectedGroup->id]) }}" method="POST"
                          class="mt-3 border-top pt-3">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-between align-items-center px-3 pb-3">
                            <div class="text-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Danger Zone
                            </div>
                            <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this group? This action cannot be undone.')">
                                <i class="bi bi-trash-fill me-2"></i>
                                Delete Group
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
