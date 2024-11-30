<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Light Instagram</title>
    <link rel="icon" href="{{ asset('images/just_logo.png') }}" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <!-- Include the Navbar -->
    <x-navbar />
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="reel">
                    <div class="reel-header">
                        <img src="{{ asset('images/profile_picture.webp') }}" alt="Profile Picture" class="profile-pic mr-2">
                        <span><strong>Username</strong></span>
                    </div>
                    <img src="https://via.placeholder.com/600x400" alt="Reel Image" class="reel-image">
                    <p>Caption for the reel goes here.</p>
                    <button class="btn btn-light">
                        <i class="fas fa-heart"></i> Like
                    </button>
                </div>
                <div class="reel">
                    <div class="reel-header">
                        <img src="https://via.placeholder.com/30" alt="Profile Picture" class="profile-pic">
                        <span>Username</span>
                    </div>
                    <video controls class="reel-video">
                        <source src="path/to/video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>Another caption for the reel.</p>
                    <button class="btn btn-light">
                        <i class="fas fa-heart"></i> Like
                    </button>
                </div>
                <!-- Add more reels as needed -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
         document.getElementById('searchButton').addEventListener('click', function() {
            const query = document.querySelector('.search-bar').value;
            if (query) {
                // Redirect to a search results page or perform a search
                window.location.href = `/search?query=${encodeURIComponent(query)}`;
            }
        });
        document.getElementById('profileDropdown').addEventListener('click', function() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('show'); // Toggle the 'show' class
        });

        // Close the dropdown if clicked outside
        window.addEventListener('click', function(event) {
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (!event.target.closest('#profileDropdown')) {
                dropdownMenu.classList.remove('show'); // Remove 'show' class if clicked outside
            }
        });
    </script>
</body>
</html>