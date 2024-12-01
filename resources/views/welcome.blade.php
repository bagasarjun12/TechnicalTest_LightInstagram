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

                <!-- Upload Content Section -->
                <div class="reel mb-4">
                    <div class="d-flex align-items-center d-flex justify-content-center">
                        <!-- Profile Picture -->
                        <img src="{{ asset('images/' . auth()->user()->photo) }}" alt="Profile Picture" class="profile-pic rounded-circle mr-2" width="50" height="50">
                        
                        <!-- Text Prompt -->
                        <h5 class="mb-0">Posting Hal Yang Menarik Disekitarmu.</h5>
                    </div>
                    
                    <div class="mt-3 d-flex justify-content-center">
                        <!-- Upload Image Button -->
                        <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#uploadImageModal">
                            <i class="fas fa-image mr-1"></i> Upload Image
                        </button>
                        
                        <!-- Upload Video Button -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#uploadVideoModal">
                            <i class="fas fa-video mr-1"></i> Upload Video
                        </button>
                    </div>
                </div>
                
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
                                <source src="{{ asset("videos/$reel->file") }}" type="video/mp4">
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

     <!-- Upload Image Modal -->
    <div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadImageModalLabel">Upload Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('upload_content') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="imageFile">Select Image (JPG, PNG)</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file-input" id="imageFile" accept=".jpg,.jpeg,.png" required>
                                <label class="custom-file-label" for="imageFile">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Max size: 15 MB</small>
                        </div>
                        <div class="form-group">
                            <img id="imagePreview" src="" alt="Image Preview" class="img-fluid" style="display: none; margin-top: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="imageCaption">Caption</label>
                            <textarea class="form-control" id="imageCaption" name="caption" rows="3" placeholder="Add a caption..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload Video Modal -->
    <div class="modal fade" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadVideoModalLabel">Upload Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('upload_content') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="videoFile">Select Video (MP4, MOV)</label>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file-input" id="videoFile" accept=".mp4,.mov" required>
                                <label class="custom-file-label" for="videoFile">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Max size: 150 MB</small>
                        </div>
                        <div class="form-group">
                            <video id="videoPreview" controls class="img-fluid" style="display: none; margin-top: 10px; max-width: 100%;">
                                <source id="videoSource" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="form-group">
                            <label for="videoCaption">Caption</label>
                            <textarea class="form-control" id="imageCaption" name="caption" rows="3" placeholder="Add a caption..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
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
                var username = $(this).data('username');
                var caption = $(this).data('caption');

                // Check if username and caption are defined
                if (username) {
                    username = username.toLowerCase();
                } else {
                    username = ''; // Fallback to an empty string
                }

                if (caption) {
                    caption = caption.toLowerCase();
                } else {
                    caption = ''; // Fallback to an empty string
                }

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

        // Image Preview
        document.getElementById('imageFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Video Preview
        document.getElementById('videoFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const videoPreview = document.getElementById('videoPreview');
                const videoSource = document.getElementById('videoSource');
                videoSource.src = URL.createObjectURL(file);
                videoPreview.load();
                videoPreview.style.display = 'block';
            }
        });
    </script>
</body>
</html>