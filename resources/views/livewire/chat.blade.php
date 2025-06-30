<div>
    <!-- Add this before your custom script -->
    <script src="https://unpkg.com/peerjs@1.4.7/dist/peerjs.min.js"></script>
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
                <!-- Video Call Button -->
                <div class="ms-auto">
                    <button type="button" class="btn btn-outline-primary rounded-circle"
                            id="video-call-btn"
                            data-user-id="{{$selectedUser->id}}"
                            style="width: 40px; height: 40px;">
                        <i class="bi bi-camera-video"></i>
                    </button>
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

    <!-- Video Call Modal -->
    <div id="video-call-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000;">
        <div class="modal-content" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 10px; padding: 20px; text-align: center;">
            <h4>Appel vidéo entrant</h4>
            <div class="video-container mb-3">
                <video id="local-video" autoplay muted style="width: 200px; height: 150px; border-radius: 10px;"></video>
                <video id="remote-video" autoplay style="width: 200px; height: 150px; border-radius: 10px; margin-left: 10px;"></video>
            </div>
            <div class="call-controls">
                <button id="accept-call-btn" class="btn btn-success me-2">
                    <i class="bi bi-telephone-fill"></i> Accepter
                </button>
                <button id="decline-call-btn" class="btn btn-danger me-2">
                    <i class="bi bi-telephone-x-fill"></i> Refuser
                </button>
                <button id="end-call-btn" class="btn btn-danger" style="display: none;">
                    <i class="bi bi-telephone-x-fill"></i> Raccrocher
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Variables globales pour l'appel vidéo
    let peer;
    let currentCall;
    let localStream;

    // Fonctions globales pour l'appel vidéo
    window.startVideoCall = function(peerId) {
        // First check device permissions
        navigator.permissions.query({name: 'camera'})
            .then(permissionStatus => {
                return navigator.mediaDevices.enumerateDevices();
            })
            .then(devices => {
                const hasVideo = devices.some(device => device.kind === 'videoinput');
                const hasAudio = devices.some(device => device.kind === 'audioinput');

                // Configure constraints based on available devices
                const constraints = {
                    video: hasVideo ? {
                        facingMode: 'user',
                        width: {ideal: 1280},
                        height: {ideal: 720}
                    } : false,
                    audio: hasAudio ? {
                        echoCancellation: true,
                        noiseSuppression: true
                    } : false
                };

                if (!hasVideo && !hasAudio) {
                    throw new Error('No media devices found');
                }

                return navigator.mediaDevices.getUserMedia(constraints);
            })
            .then(stream => {
                localStream = stream;
                document.getElementById('local-video').srcObject = stream;

                const call = peer.call(peerId, stream);
                currentCall = call;

                call.on('stream', (remoteStream) => {
                    document.getElementById('remote-video').srcObject = remoteStream;
                });

                call.on('close', () => {
                    endCall();
                });

                showCallInProgressUI();
            })
            .catch(err => {
                console.error('Media access error:', err);

                if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    // Try fallback to audio only if video fails
                    startVideoCallFallback(peerId);
                } else {
                    handleMediaError(err);
                }
            });
    };

    window.answerCall = function () {
        checkMediaDevices().then(({hasVideo, hasAudio}) => {
            const constraints = {
                video: hasVideo ? {
                    facingMode: 'user',
                    width: {ideal: 1280},
                    height: {ideal: 720}
                } : false,
                audio: hasAudio ? {
                    echoCancellation: true,
                    noiseSuppression: true
                } : false
            };

            return navigator.mediaDevices.getUserMedia(constraints)
                .then(stream => {
                    localStream = stream;
                    document.getElementById('local-video').srcObject = stream;

                    currentCall.answer(stream);

                    currentCall.on('stream', (remoteStream) => {
                        document.getElementById('remote-video').srcObject = remoteStream;
                    });

                    showCallInProgressUI();
                })
                .catch(err => {
                    console.error('Erreur d\'accès aux médias:', err);
                    handleMediaError(err);
                });
        }).catch(err => {
            console.error('Périphériques non disponibles:', err);
            alert('Aucune caméra ou microphone détecté. Veuillez vérifier vos périphériques.');
        });
    };

    window.endCall = function() {
        if (currentCall) {
            currentCall.close();
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
        }
        hideCallUI();
    };

    // Fonction pour vérifier la disponibilité des périphériques
    async function checkMediaDevices() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const hasVideo = devices.some(device => device.kind === 'videoinput');
            const hasAudio = devices.some(device => device.kind === 'audioinput');

            if (!hasVideo && !hasAudio) {
                throw new Error('Aucun périphérique audio/vidéo trouvé');
            }

            console.log('Périphériques disponibles:', {
                caméra: hasVideo,
                microphone: hasAudio
            });

            return { hasVideo, hasAudio };
        } catch (error) {
            console.error('Erreur lors de la vérification des périphériques:', error);
            throw error;
        }
    }

    // Fonction pour gérer les erreurs d'accès aux médias
    function handleMediaError(error) {
        let message = 'Device access error: ';

        switch (error.name) {
            case 'NotFoundError':
            case 'DevicesNotFoundError':
                message += 'No camera or microphone found. Please connect your devices.';
                // Try audio-only fallback
                startVideoCallFallback(currentCall?.peer);
                break;
            case 'NotAllowedError':
            case 'PermissionDeniedError':
                message += 'Permissions refusées. Veuillez autoriser l\'accès à la caméra et au microphone dans les paramètres du navigateur.';
                break;
            case 'NotReadableError':
            case 'TrackStartError':
                message += 'Périphériques déjà utilisés par une autre application. Veuillez fermer les autres applications utilisant la caméra/microphone.';
                break;
            case 'OverconstrainedError':
            case 'ConstraintNotSatisfiedError':
                message += 'Configuration des périphériques non supportée.';
                break;
            case 'TypeError':
                message += 'Configuration invalide.';
                break;
            case 'AbortError':
                message += 'Opération interrompue.';
                break;
            default:
                message += error.message || 'Erreur inconnue';
        }

        alert(message);
        console.error('Détails de l\'erreur:', error);
    }

    // Version alternative avec paramètres plus permissifs
    window.startVideoCallFallback = function(peerId) {
        // Essayer d'abord avec audio et vidéo
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(handleStream)
            .catch(() => {
                // Si échec, essayer seulement audio
                console.log('Tentative avec audio seulement...');
                return navigator.mediaDevices.getUserMedia({ video: false, audio: true });
            })
            .then(handleStream)
            .catch(() => {
                // Si échec, essayer seulement vidéo
                console.log('Tentative avec vidéo seulement...');
                return navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            })
            .then(handleStream)
            .catch(err => {
                console.error('Impossible d\'accéder aux périphériques:', err);
                handleMediaError(err);
            });

        function handleStream(stream) {
            localStream = stream;
            document.getElementById('local-video').srcObject = stream;

            const call = peer.call(peerId, stream);
            currentCall = call;

            call.on('stream', (remoteStream) => {
                document.getElementById('remote-video').srcObject = remoteStream;
            });

            call.on('close', () => {
                endCall();
            });

            showCallInProgressUI();
        }
    };

    function initializePeer() {
        // Create a peer with the current user's ID
        peer = new Peer("user_{{ auth()->id() }}");

        peer.on('open', (id) => {
            console.log('PeerJS connected with ID:', id);
        });

        peer.on('call', (incomingCall) => {
            currentCall = incomingCall;
            showCallRequestModal(incomingCall.peer);
        });

        peer.on('error', (err) => {
            console.error('PeerJS error:', err);
        });
    }

    function showCallRequestModal(callerPeerId) {
        document.getElementById('video-call-modal').style.display = 'block';
    }

    function showCallInProgressUI() {
        document.getElementById('accept-call-btn').style.display = 'none';
        document.getElementById('decline-call-btn').style.display = 'none';
        document.getElementById('end-call-btn').style.display = 'block';
        document.getElementById('video-call-modal').style.display = 'block';
    }

    function hideCallUI() {
        const modal = document.getElementById('video-call-modal');
        const acceptBtn = document.getElementById('accept-call-btn');
        const declineBtn = document.getElementById('decline-call-btn');
        const endBtn = document.getElementById('end-call-btn');
        const localVideo = document.getElementById('local-video');
        const remoteVideo = document.getElementById('remote-video');

        modal.style.display = 'none';
        acceptBtn.style.display = 'inline-block';
        declineBtn.style.display = 'inline-block';
        endBtn.style.display = 'none';

        if (localVideo.srcObject) {
            localVideo.srcObject.getTracks().forEach(track => track.stop());
            localVideo.srcObject = null;
        }
        if (remoteVideo.srcObject) {
            remoteVideo.srcObject.getTracks().forEach(track => track.stop());
            remoteVideo.srcObject = null;
        }
    }

    document.addEventListener('livewire:initialized', function () {
        // Initialize PeerJS when the component loads
        initializePeer();

        // Ajouter l'event listener pour le bouton d'appel vidéo
        document.getElementById('video-call-btn').addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            startVideoCall('user_' + userId);
        });

        // Ajouter les event listeners pour les boutons du modal
        document.getElementById('accept-call-btn').addEventListener('click', answerCall);
        document.getElementById('decline-call-btn').addEventListener('click', endCall);
        document.getElementById('end-call-btn').addEventListener('click', endCall);

        // Le reste du code Livewire...
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
        });

        // Listen for video call events
        window.Echo.private(`video-call.{{ auth()->id() }}`)
            .listen('RequestVideoCall', (e) => {
                showCallRequestModal(e.user.peerId);
            })
            .listen('RequestVideoCallStatus', (e) => {
                if (e.user.status === 'accepted') {
                    // The call was accepted, establish connection
                } else {
                    // Call was declined
                    alert('Call was declined');
                    hideCallUI();
                }
            });

        window.Echo.private(`video-call.{{$loginID}}`)
            .listen('RequestVideoCall', (e) => {
                console.log('Video call request from:', e.user);
                showCallRequestModal(e.user);
            })
            .listen('RequestVideoCallStatus', (e) => {
                console.log('Video call status update:', e.user);
            });
    });
</script>
