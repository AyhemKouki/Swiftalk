<div>
    <h1 class="display-4">Chat</h1>
    <p class="lead mb-4">communicate with others</p>
    <hr class="my-4">

    <!-- Chat Container -->
    <div class="d-flex"
         style="height: 600px; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); background-color: white;">
        <style>
            .user-list-item:hover:not(.selected-user) {
                background-color: #F3F3F4;
            }

            .selected-user {
                background-color: #4485FF !important;
                color: white;
            }

            .selected-user .text-muted {
                color: #e9ecef !important;
            }
        </style>
        <!-- Left: User List -->
        <div class="w-25 border-end">
            <div class="p-4 fw-bold text-dark border-bottom">
                <i class="bi bi-people-fill me-2"></i>Users
            </div>
            <div class="overflow-auto" style="height: calc(100% - 69px);">
                @foreach($users as $user)
                    <div wire:click="selectUser({{$user->id}})"
                         class="p-3 border-bottom user-list-item @if($selectedUser->id === $user->id) selected-user @endif"
                         style="cursor: pointer; transition: background-color 0.2s ease;">
                    <div class="d-flex align-items-center">
                            <div class="position-relative">
                                <img src="{{asset('images/male.jpg')}}" alt="User Avatar" class="rounded-circle"
                                     width="40"
                                     height="40">
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle"
                                      style="width: 12px; height: 12px; border: 2px solid white;"></span>
                            </div>
                            <div class="ms-3">
                                <div class="fw-semibold">{{$user->name}}</div>
                                <div class="small text-muted">{{$user->email}}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Chat Section -->
        <div class="w-75 d-flex flex-column">
            <!-- Header -->
            <div class="p-4 border-bottom d-flex align-items-center">
                <div class="position-relative">
                    <img src="{{asset('images/male.jpg')}}" alt="User Avatar" class="rounded-circle" width="48"
                         height="48">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle"
                          style="width: 12px; height: 12px; border: 2px solid white;"></span>
                </div>
                <div class="ms-3">
                    <div class="h5 fw-bold mb-0">{{$selectedUser->name}}</div>
                    <div class="small text-muted">Online</div>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-grow-1 p-4 overflow-auto" style="background-color: #f8f9fa;">
                @foreach($messages as $message)
                    <div
                        class="d-flex flex-column @if($message->sender_id === auth()->id()) align-items-end @endif mb-3">
                        <div
                            class="px-4 py-2 rounded-4 shadow-sm @if($message->sender_id === auth()->id()) bg-primary text-white @else bg-white @endif"
                            style="max-width: 24rem;">
                            <div
                                class="small @if($message->sender_id === auth()->id()) text-white-50 @else text-muted @endif mb-1">
                                {{ $message->sender_id === auth()->id() ? 'You' : $selectedUser->name }}
                            </div>
                            {{$message->message}}
                        </div>
                        <div class="small text-muted mt-1">
                            {{ $message->created_at->format('g:i A') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Input -->
            <form wire:submit="submit" class="p-4 border-top d-flex align-items-center gap-3">
                <input
                    wire:model="newMessage"
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
        </div>
    </div>
</div>
