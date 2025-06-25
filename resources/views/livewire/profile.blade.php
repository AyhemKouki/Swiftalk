<div>

    <h1 class="display-4">Edit profile</h1>
    <p class="lead mb-4">Update your account's profile information and email address.</p>
    <hr class="my-4">

    <div class="profile-container">
        <div class="profile-header">
            <h1 class="profile-title">Edit Profile</h1>
            <p class="profile-subtitle">Manage your account settings and personal information</p>
        </div>

        <div class="profile-sections">
            <!-- Profile Information Section -->
            <div class="profile-section">
                <div class="section-header">
                    <div class="profile-image-container">
                        @if(auth()->user()->profile_image)
                            <img src="{{ Storage::url(auth()->user()->profile_image) }}" alt="Profile picture"
                                 class="profile-image">
                        @else
                            <div class="profile-image-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="section-title">Profile Information</h2>
                    <p class="section-description">Update your account's profile information and email address</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="profile-form"
                      enctype="multipart/form-data">
                @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <div class="input-wrapper">
                            <input id="profile_image" name="profile_image" type="file" class="form-input"
                                   accept="image/*">
                        </div>
                        @error('profile_image')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-wrapper">
                            <input id="name" name="name" type="text" class="form-input"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required autofocus autocomplete="name">
                        </div>
                        @error('name')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input id="email" name="email" type="email" class="form-input"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required autocomplete="username">
                        </div>
                        @error('email')
                        <p class="form-error">{{ $message }}</p>
                        @enderror

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                            <div class="verification-notice">
                                <p>Your email address is unverified.</p>
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button type="submit" class="verification-link">
                                        Click here to re-send the verification email.
                                    </button>
                                </form>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="verification-success">
                                        A new verification link has been sent to your email address.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            Save Changes
                        </button>
                        @if (session('status') === 'profile-updated')
                            <p class="save-message" id="save-message">
                                Saved successfully
                            </p>
                            <script>
                                setTimeout(() => {
                                    document.getElementById('save-message').style.display = 'none';
                                }, 3000);
                            </script>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Update Password Section -->
            <div class="profile-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="section-title">Update Password</h2>
                    <p class="section-description">Ensure your account is using a secure password</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="profile-form">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="update_password_current_password" class="form-label">Current Password</label>
                        <div class="input-wrapper">
                            <input id="update_password_current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
                        </div>
                        @error('current_password', 'updatePassword')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="update_password_password" class="form-label">New Password</label>
                        <div class="input-wrapper">
                            <input id="update_password_password" name="password" type="password" class="form-input" autocomplete="new-password">
                        </div>
                        @error('password', 'updatePassword')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-wrapper">
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            Update Password
                        </button>
                        @if (session('status') === 'password-updated')
                            <p class="save-message" id="password-save-message">
                                Password updated successfully
                            </p>
                            <script>
                                setTimeout(() => {
                                    document.getElementById('password-save-message').style.display = 'none';
                                }, 3000);
                            </script>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Delete Account Section -->
            <div class="profile-section danger-section">
                <div class="section-header">
                    <div class="header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="section-title">Delete Account</h2>
                    <p class="section-description">Permanently remove your account and all associated data</p>
                </div>

                <div class="delete-content">
                    <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

                    <button type="button" class="btn-danger" onclick="document.getElementById('delete-modal').showModal()">
                        Delete Account
                    </button>
                </div>

                <!-- Delete Account Modal -->
                <dialog id="delete-modal" class="modal">
                    <div class="modal-content">
                        <h3>Are you sure you want to delete your account?</h3>
                        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

                        <form method="post" action="{{ route('profile.destroy') }}" class="delete-form">
                            @csrf
                            @method('delete')

                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-wrapper">
                                    <input id="password" name="password" type="password" class="form-input" placeholder="Enter your password">
                                </div>
                                @error('password', 'userDeletion')
                                <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="modal-actions">
                                <button type="button" class="btn-secondary" onclick="document.getElementById('delete-modal').close()">
                                    Cancel
                                </button>
                                <button type="submit" class="btn-danger">
                                    Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>
        </div>
    </div>

    <style>
        /* Profile Image Styles */
        .profile-image-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #e5e7eb;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
        }

        .profile-image-placeholder svg {
            width: 60%;
            height: 60%;
            color: #9ca3af;
        }

        /* Base Styles */
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            color: #1f2937;
        }

        .profile-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .profile-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .profile-subtitle {
            font-size: 1.125rem;
            color: #4b5563;
            max-width: 600px;
            margin: 0 auto;
        }

        .profile-sections {
            display: grid;
            gap: 2rem;
        }

        .profile-section {
            background: white;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .danger-section {
            border-color: #fecaca;
        }

        .section-header {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .header-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background-color: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .danger-section .header-icon {
            background-color: #fee2e2;
        }

        .header-icon svg {
            width: 1.5rem;
            height: 1.5rem;
            color: #3b82f6;
        }

        .danger-section .header-icon svg {
            color: #ef4444;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        .section-description {
            color: #6b7280;
        }

        .profile-form {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .save-message {
            color: #10b981;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .verification-notice {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            color: #92400e;
        }

        .verification-link {
            color: #92400e;
            text-decoration: underline;
            font-weight: 500;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .verification-link:hover {
            color: #78350f;
        }

        .verification-success {
            color: #065f46;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .delete-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .delete-content p {
            color: #6b7280;
        }

        .btn-danger {
            align-self: flex-start;
            background-color: #ef4444;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-secondary {
            background-color: white;
            color: #374151;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            border: 1px solid #d1d5db;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
        }

        /* Modal Styles */
        .modal {
            border: none;
            border-radius: 0.75rem;
            padding: 0;
            width: 90%;
            max-width: 500px;
        }

        .modal::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            padding: 2rem;
        }

        .modal-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #111827;
        }

        .modal-content p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .delete-form {
            display: grid;
            gap: 1.5rem;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        @media (min-width: 768px) {
            .profile-sections {
                grid-template-columns: 1fr 1fr;
            }

            .profile-section:last-child {
                grid-column: span 2;
            }
        }
    </style>


</div>
