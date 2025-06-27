<div>
    <h1 class="display-4">Chat</h1>
    <p class="lead mb-4">communicate with others</p>
    <hr class="my-4">

    <!-- Chat Container -->
    <div class="d-flex"
         style="height: 750px; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); background-color: white;">
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
                                @if($user->profile_image)
                                    <img src="{{asset('storage/'.$user->profile_image)}}" alt="User Avatar" class="rounded-circle"
                                         width="40"
                                         height="40">
                                @else
                                    <img src="{{asset('images/male.jpg')}}" alt="User Avatar" class="rounded-circle"
                                         width="40"
                                         height="40">
                                @endif

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
                    @if($selectedUser->profile_image)
                        <img src="{{asset('storage/'.$selectedUser->profile_image)}}" alt="User Avatar" class="rounded-circle"
                             width="40"
                             height="40">
                    @else
                        <img src="{{asset('images/male.jpg')}}" alt="User Avatar" class="rounded-circle"
                             width="40"
                             height="40">
                    @endif
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle"
                          style="width: 12px; height: 12px; border: 2px solid white;"></span>
                </div>
                <div class="ms-3">
                    <div class="h5 fw-bold mb-0">{{$selectedUser->name}}</div>
                    <div class="small text-muted">Online</div>
                </div>
            </div>

            <!-- Messages -->
            <div x-data="{
                    scrollToBottom() {
                        setTimeout(() => {
                            this.$refs.messagesContainer.scrollTo({
                                top: this.$refs.messagesContainer.scrollHeight,
                                behavior: 'smooth'
                            });
                        }, 50);
                    }
                }"
                 x-init="scrollToBottom()"
                 @scroll-to-bottom.window="scrollToBottom()"
                 x-ref="messagesContainer"
                 class="flex-grow-1 p-4 overflow-auto"
                 style="background-color: #f8f9fa;">
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
                            <div>{{$message->message}}</div>
                            @if($message->hasAttachment())
                                <div class="mt-2">
                                    @php
                                        $fileType = strtolower(pathinfo($message->attachment_name, PATHINFO_EXTENSION));
                                        $isImage = in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp

                                    @if($isImage)
                                        <div class="attachment-preview mb-2">
                                            <img src="{{ $message->getAttachmentUrl() }}" alt="Attachment Preview"
                                                 class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                    @endif

                                    <a href="{{ $message->getAttachmentUrl() }}" target="_blank"
                                       class="d-flex align-items-center p-2 rounded bg-light text-decoration-none">
                                        <i class="bi bi-{{ $isImage ? 'image' : ($fileType == 'pdf' ? 'file-pdf' :
                                            ($fileType == 'doc' || $fileType == 'docx' ? 'file-word' :
                                            ($fileType == 'xls' || $fileType == 'xlsx' ? 'file-excel' :
                                            'file-earmark'))) }} me-2"></i>
                                        <div class="d-flex flex-column">
                                            <span class="small text-truncate" style="max-width: 200px;">
                                                {{ $message->attachment_name }}
                                            </span>
                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                {{ $message->attachment_type }}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="small text-muted mt-1">
                            {{ $message->created_at->format('g:i A') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="typing-indicator" class="p-2 align-items-center"
                 style="gap: 4px; background-color: #f8f9fa; display: none; transition: opacity 0.3s;">
            <span id="typing-text" class="text-muted small"></span>
                <div class="typing-dots d-flex" style="gap: 3px;">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <style>
                    .typing-dots {
                        display: none;
                        align-items: center;
                    }

                    .dot {
                        width: 3px;
                        height: 3px;
                        background: #5c5d62;
                        border-radius: 50%;
                        animation: typing 1.5s infinite ease-in-out;
                    }

                    .dot:nth-child(2) {
                        animation-delay: 0.2s;
                    }

                    .dot:nth-child(3) {
                        animation-delay: 0.4s;
                    }

                    @keyframes typing {
                        0%, 60%, 100% {
                            transform: translateY(0);
                        }
                        30% {
                            transform: translateY(-2px);
                        }
                    }
                </style>
            </div>

            <!-- Input -->
            <form wire:submit="submit" class="p-4 border-top">
                <div class="d-flex flex-column gap-2">
                    @if($attachment)
                        <div class="d-flex align-items-center gap-2 bg-light p-2 rounded">
                            <i class="bi bi-paperclip"></i>
                            <span class="small">{{ $attachment->getClientOriginalName() }}</span>
                            <button type="button" class="btn btn-sm text-danger" wire:click="removeAttachment">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    @endif
                    <div class="d-flex align-items-center gap-3">
                        <input
                            wire:model.live="newMessage"
                            type="text"
                            class="form-control rounded-pill border-0 shadow-sm px-4 py-3"
                            placeholder="Type your message..."
                            style="background-color: #f8f9fa;"
                        />
                        <label
                            class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 46px; height: 46px;">
                            <i class="bi bi-paperclip"></i>
                            <input type="file" wire:model="attachment" class="d-none">
                        </label>
                        <button
                            type="submit"
                            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 46px; height: 46px;"
                        >
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', function () {
        Livewire.on('userTyping', function (event) {
            console.log(event);
            window.Echo.private(`chat.${event.selectedUserID}`).whisper('typing', {
                userID: event.userID,
                userName: event.userName,
            });
        });
        window.Echo.private(`chat.{{$loginID}}`).listenForWhisper('typing', (e) => {
            const indicator = document.getElementById('typing-indicator');
            const dots = document.querySelector('.typing-dots');
            const text = document.getElementById('typing-text');
            text.innerText = `${e.userName} is typing`;
            indicator.style.display = 'flex';
            dots.style.display = 'flex';
            setTimeout(() => {
                text.innerText = '';
                indicator.style.display = 'none';
                dots.style.display = 'none';
            }, 2000);
        })
    });
</script>
