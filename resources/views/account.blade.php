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
    <link rel="stylesheet" href="{{ asset('css/acc_styles.css') }}">
</head>
<body>
    <!-- Include the Navbar -->
    <x-navbar_blank />

    <div class="container mt-5">
        <div class="profile-box">
            <div class="profile-container">
                <img src="{{ asset('images/'.$user->photo ) }}" alt="Profile" class="profile-img rounded-circle mr-2">
                <div class="profile-info">
                    <h5 class="font-weight-bold text-left">{{  $user->username }}</h5>
                    <button class="btn btn-primary rounded-pill" onclick="location.href='{{ route('profile.edit') }}'">
                        Edit Profile
                    </button>
                    <div class="mt-2 text-left">
                        <span class="mr-3">{{ $reels_count }} Posts</span>
                        <span>{{ $archive_count }} Archives</span>
                    </div>
                    <div class="mt-2 text-left">
                        <span class="bio-text">{{ $user->biodata }}</span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row mt-3">
            <div class="col-6">
                <div class="btn-custom-width">
                    <a href="{{ route('archive') }}" class="btn btn-success rounded">
                        <i class="fas fa-archive mr-1" aria-hidden="true"></i>Archive
                    </a>
                </div>
            </div>
            <div class="col-6 text-right">
                <select class="custom-select w-50 unique-select-rows" id="imageRowSelector">
                    <option value="2">2 Row</option>
                    <option value="3" selected>3 Row</option>
                    <option value="4">4 Row</option>
                </select>
            </div>
        </div>
    
        <div class="row mt-3" id="imageContainer">
            @foreach($reels as $reel)
                <div class="col-4 mb-3 image-item">
                    @if($reel->type_file === 'image')
                        <!-- Display image -->
                        <img src="{{ asset('reels/'.$reel->file) }}" alt="Reel Image" role="button" class="img-fluid" data-toggle="modal" data-target="#imageModal{{ $reel->id_reels }}">
                    @elseif($reel->type_file === 'video')
                        <!-- Display video -->
                        <video class="img-fluid" controls role="button" data-toggle="modal" data-target="#imageModal{{ $reel->id_reels }}">
                            <source src="{{ asset('videos/'.$reel->file) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                </div>

                <!-- Modal for each reel -->
                <div class="modal fade" id="imageModal{{ $reel->id_reels }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $reel->id_reels }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $reel->id_reels }}">Content Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    @if($reel->type_file === 'image')
                                        <!-- Display image in modal -->
                                        <img src="{{ asset('reels/'.$reel->file) }}" alt="Reel Image" class="img-fluid" style="width: 370px; height: auto;">
                                    @elseif($reel->type_file === 'video')
                                        <!-- Display video in modal -->
                                        <div class="video-wrapper">
                                            <video class="img-fluid" controls>
                                                <source src="{{ asset('videos/'.$reel->file) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <?php
                                    // Initialize the like count and liked status
                                    $count = 0;

                                    // Calculate the number of likes and check if the user has liked this reel
                                    foreach ($atribut as $atr) {
                                        if ($reel->id_reels == $atr->id_reels) {
                                            if ($atr->type == "like") {
                                                $count++; // Increment like count
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="btn btn-light like-button ml-5 mr-5 mb-2">
                                        <i class="fas fa-heart mr-1 text-danger"></i> {{ $count }} Likes
                                    </div>
                                    <div class="ml-5"><strong>Caption</strong></div>
                                    <div class="ml-5">{{ $reel->caption }}</div>
                                </div>
                            
                                <div class="mt-4 d-flex justify-content-between">
                                    <a href="{{ route('delete_reel', $reel->id_reels) }}" class="btn btn-danger me-2" onclick="return confirmDelete();">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </a>
                                    <a href="{{ route('archive_reel', $reel->id_reels) }}" class="btn btn-secondary" onclick="return confirm('Are you sure you want to archive this reel?');">
                                        Masukkan Ke Archive
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update the layout based on the selected value
            function updateLayout() {
                var selectedValue = $('#imageRowSelector').val();
                var imageContainer = $('#imageContainer');
    
                // Remove existing classes
                imageContainer.removeClass('row2 row3 row4');
    
                // Add new class based on selection
                if (selectedValue == '4') {
                    imageContainer.addClass('row4');
                    $('.image-item').removeClass('col-6 col-4').addClass('col-3'); // Change to 4 images per row
                } else if (selectedValue == '3') {
                    imageContainer.addClass('row3');
                    $('.image-item').removeClass('col-6 col-3').addClass('col-4'); // Change to 3 images per row
                } else {
                    imageContainer.addClass('row2');
                    $('.image-item').removeClass('col-4 col-3').addClass('col-6'); // Change to 2 images per row
                }
            }
    
            // Call updateLayout on change of the dropdown
            $('#imageRowSelector').change(updateLayout);
            
            // Call updateLayout on page load to set the initial state
            updateLayout();
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this reel?');
        }
    </script>
    
</body>
</html>