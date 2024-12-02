<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive; 
use League\Csv\Writer;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ArchiveController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        //Grab data archive
        $data = Archive::with('image')->where('id_users', $user->id)->get();

        return view('archive', compact('data'));
    }

    public function downloadCsv(Request $request)
    {
        $startDate = \Carbon\Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = \Carbon\Carbon::parse($request->input('end_date'))->endOfDay();
   
        $archives = Archive::whereBetween('created_at', [$startDate, $endDate])->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(['File', 'Type File', 'Caption', 'Username', 'Email', 'Like', 'Upload Date','Archived Date'], NULL, 'A1');

        $row = 2;
        foreach ($archives as $archive) {
            $sheet->fromArray([
                basename($archive->image->file),
                $archive->image->type_file,
                $archive->caption,
                $archive->user->username,
                $archive->user->email,
                $archive->like,
                $archive->upload_date->format('d M y H:i'),
                $archive->created_at->format('d M y H:i'),
            ], NULL, 'A' . $row);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'archive-' . auth()->user()->username . '-' . $startDate->format('d-m-Y') . '-' . $endDate->format('d-m-Y') . '.xlsx';

        return Response::stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $startDate = \Carbon\Carbon::parse($request->input('start_date'))->startOfDay();
        $endDate = \Carbon\Carbon::parse($request->input('end_date'))->endOfDay();

        $archives = Archive::whereBetween('created_at', [$startDate, $endDate])->get();

        $pdf = PDF::loadView('pdf.archive_pdf', ['archives' => $archives]);

        return $pdf->download('archive-' . auth()->user()->username . '-' . $startDate->format('d-m-Y') . '-' . $endDate->format('d-m-Y') . '.pdf');
    }

}
