<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; /* Mengurangi ukuran font */
        }
        th, td {
            border: 1px solid black;
            text-align: left;
            padding: 5px;
            word-wrap: break-word; /* Memastikan teks panjang turun ke baris berikutnya */
        }
        th {
            background-color: #f2f2f2;
        }
        .file-name {
            font-size: 9px; /* Ukuran font lebih kecil untuk nama file */
            white-space: pre-wrap; /* Memaksa teks untuk membungkus jika terlalu panjang */
        }
        .truncate-multiline {
            display: inline-block;
            max-width: 15ch; /* Maksimum 15 karakter */
            overflow-wrap: break-word; /* Memotong kata panjang */
            white-space: normal; /* Memungkinkan teks turun ke baris berikutnya */
            word-break: break-word; /* Memotong pada kata jika diperlukan */
        }
    </style>
</head>
<body>
    <h2>Archives</h2>
    <table>
        <thead>
            <tr>
                <th>File</th>
                <th>Type File</th>
                <th>Caption</th>
                <th>Username</th>
                <th>Email</th>
                <th>Like</th>
                <th>Upload Date</th>
                <th>Archived Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archives as $archive)
                <tr>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#fileModal" 
                           data-file="{{ $archive->image->file }}" 
                           data-type="{{ $archive->image->type_file }}" 
                           class="truncate-multiline" id="fileName">
                           {{ basename($archive->image->file) }}
                        </a>
                    </td>
                    <td>{{ $archive->image->type_file }}</td>
                    <td>{{ $archive->caption }}</td>
                    <td>{{ $archive->user->username }}</td>
                    <td>{{ $archive->user->email }}</td>
                    <td>{{ $archive->like ?? 0 }}</td>
                    <td>{{ $archive->upload_date->format('d M y H:i') }}</td>
                    <td>{{ $archive->created_at->format('d M y H:i') }}</td> <!-- Menambahkan Created At -->
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>
