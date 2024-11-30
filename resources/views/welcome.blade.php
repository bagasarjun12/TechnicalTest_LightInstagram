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

    <div class="container mt-4 custom-width" id="reelsContainer">
        <div class="row">
            <div class="col-12">
                @if(session('alert'))
                    <div class="alert alert-{{ session('alert.type') }} alert-dismissible fade show mt-3" role="alert">
                        {{ session('alert.message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @foreach ($reels as $reel)
                    <div class="reel" data-username="{{ $reel->username }}" data-caption="{{ $reel->caption }}">
                        <div class="reel-header">
                            <img src="{{ asset("images/$reel->profile_picture") }}" alt="Profile Picture" class="profile-pic mr-2">
                            <span class="font-weight-bold">{{ $reel->username }}</span>
                        </div>
                        @if ($reel->type_file === 'image')
                            <img src="{{ asset("reels/$reel->file") }}" alt="Reel Image" class="reel-image">
                        @elseif ($reel->type_file === 'video')
                            <video controls class="reel-video">
                                <source src="{{ asset("reels/$reel->file") }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif 
                        <p>{{ $reel->caption ?? 'This Post Does Not Have A Caption' }}</p>
                        
                        <?php
                            // Initialize the like count and liked status
                            $count = 0; 
                            $liked = false; // Initialize liked variable
    
                            // Calculate the number of likes and check if the user has liked this reel
                            foreach ($atributs as $atr) {
                                if ($reel->id_reels == $atr->id_reels) {
                                    if ($atr->type == "like") {
                                        $count++; // Increment like count
                                        if ($atr->id_users == auth()->id()) {
                                            $liked = true; // User has liked this reel
                                        }
                                    }
                                }
                            }
                        ?>
                        <form action="{{ route('like') }}" method="POST" class="cf-form{{ $reel->id_reels }}">
                            @csrf <!-- Include CSRF token for security -->
                            <input type="hidden" name="reel_id" value="{{ $reel->id_reels }}"> <!-- Hidden input for reel ID -->
                            
                            <button class="btn btn-light like-button">
                                <i class="fas fa-heart mr-1 @if($liked) text-danger @endif"></i> {{ $count }} Likes
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- No Match Message -->
    <div id="noMatchMessage" style="display: none; text-align: center; margin-top: 20px;">
        <h4></h4>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to perform the search
            function performSearch() {
                var searchValue = $('#searchInput').val().toLowerCase();
                var hasMatch = false; // Flag to track if any matches are found
    
                $('#reelsContainer .reel').each(function() {
                    var username = $(this).data('username').toLowerCase();
                    var caption = $(this).data('caption') ? $(this).data('caption').toLowerCase() : '';
    
                    // Check if the username or caption matches the search input
                    if (username.includes(searchValue) || caption.includes(searchValue)) {
                        $(this).show(); // Show the reel if it matches
                        hasMatch = true; // Set flag to true if a match is found
                    } else {
                        $(this).hide(); // Hide the reel if it doesn't match
                    }
                });
    
                // Show or hide the "No Match" message based on whether any matches were found
                if (!hasMatch) {
                    $('#noMatchMessage').text('Nothing found, let’s keep looking!').show(); // Show the no match message
                } else {
                    $('#noMatchMessage').hide(); // Hide the no match message
                }
            }
    
            // Trigger search on button click
            $('#searchButton').click(function() {
                performSearch();
            });
    
            // Trigger search on pressing the Enter key
            $('#searchInput').keypress(function(event) {
                if (event.which === 13) { // 13 is the Enter key
                    performSearch();
                }
            });
        });
    </script>
</body>
</html>