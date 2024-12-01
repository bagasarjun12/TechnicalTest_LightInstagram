<x-app-layout>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Include the Navbar -->
    <x-navbar_blank />
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Profile Information') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </header>
                <form method="POST" action="{{ route('profile_update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <x-input-label :value="__('Username')" />
                        <input disabled type="text" name="username" id="username" class="form-control" value="{{ old('username', auth()->user()->username) }}" required>
                    </div>
                    <small class="form-text text-muted mb-2">Upload a new profile photo (optional).</small>
                    <x-input-label :value="__('Photo Profile')" class="mr-3" />
                    <div class="form-group d-flex align-items-center"> 
                        <!-- Display the existing profile photo -->
                        <img src="{{ asset('images/' . auth()->user()->photo) }}" alt="Profile Photo" class="rounded-circle" id="profile-photo" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #007bff;">
                    
                        <div class="custom-file ml-5">
                            <input type="file" name="photo" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept="image/*" onchange="previewImage(event)">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <x-input-label :value="__('Biodata')" />
                        <textarea name="biodata" id="biodata" class="form-control" maxlength="150" rows="3" required>{{ old('biodata', auth()->user()->biodata) }}</textarea>
                    </div>

                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            // Check if the file is an image and less than 15MB
            if (file && file.size <= 15 * 1024 * 1024 && file.type.startsWith('image/')) {
                reader.onload = function(e) {
                    const img = document.getElementById('profile-photo');
                    img .src = e.target.result; // Set the image source to the uploaded file
                }
                reader.readAsDataURL(file); // Read the uploaded file as a data URL
            } else {
                alert('Please select a valid image file (max size: 15MB).');
                event.target.value = ''; // Clear the input
            }
        }
    </script>
</x-app-layout>