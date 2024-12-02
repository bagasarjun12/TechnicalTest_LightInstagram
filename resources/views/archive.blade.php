<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Archive</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/archive_styles.css') }}">
</head>
<body>
    <x-navbar_blank />

    <div class="archive-container mt-4">
        <h2 class="mb-4">My Archives</h2>

        <!-- Download Buttons with Date Selection -->
        <form method="GET" action="{{ route('archive.download.csv') }}" class="mb-4">
            <div class="form-row w-50">
                <div class="form-group col-md-4">
                    <label for="startDateCSV">Start Date</label>
                    <input type="date" class="form-control" id="startDateCSV" name="start_date" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="endDateCSV">End Date</label>
                    <input type="date" class="form-control" id="endDateCSV" name="end_date" required>
                </div>
                <div class="form-group col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary">Download as CSV</button>
                </div>
            </div>
        </form>
        

        <form method="GET" action="{{ route('archive.download.pdf') }}" class="mb-4">
            <div class="form-row w-50">
                <div class="form-group col-md-4">
                    <label for="startDatePDF">Start Date</label>
                    <input type="date" class="form-control" id="startDatePDF" name="start_date" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="endDatePDF">End Date</label>
                    <input type="date" class="form-control" id="endDatePDF" name="end_date" required>
                </div>
                <div class="form-group col-md-4 align-self-end">
                    <button type="submit" class="btn btn-danger">Download as PDF</button>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Type File</th>
                    <th class="col-3">Caption</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Like</th>
                    <th class="col-2">Upload Date</th>
                    <th class="col-2">Archived Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $archive)
                <tr>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#fileModal" 
                           data-file="{{ $archive->image->file }}" 
                           data-type="{{ $archive->image->type_file }}" 
                           class="truncate" id="fileName">
                           {{ basename($archive->image->file) }}
                        </a>
                    </td>
                    <td>{{ $archive->image->type_file }}</td>
                    <td>{{ $archive->caption }}</td>
                    <td>{{ $archive->user->username }}</td>
                    <td>{{ $archive->user->email }}</td>
                    <td>{{ $archive->like }}</td>
                    <td>{{ $archive->upload_date->format('d M y H:i') }}</td>
                    <td>{{ $archive->created_at->format('d M y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal for File Preview -->
    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="file-preview">
                        <img src="" alt="Reel Image" class="img-fluid" style="width: 370px; height: auto; display: none;" id="imagePreview">
                        <video class="img-fluid" controls id="videoPreview" style="display: none;">
                            <source src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Event listener for the file links
        $('#fileModal').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget); // Button that triggered the modal
            var file = link.data('file'); // Extract info from data-* attributes
            var type = link.data('type');

            var imagePreview = $('#imagePreview');
            var videoPreview = $('#videoPreview');

            // Clear previous content
            imagePreview.hide();
            videoPreview.hide();

            // Set the source based on the type
            if (type === 'image') {
                imagePreview.attr('src', '{{ asset('reels/') }}/' + file).show();
            } else if (type === 'video') {
                videoPreview.find('source').attr('src', '{{ asset('videos/') }}/' + file);
                videoPreview[0].load(); // Load the new video
                videoPreview.show();
            }
        });
    </script>
</body>
</html>