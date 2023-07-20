<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::latest()->get();
        return view('dashboard.files.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpeg,jpg',
            // |max:2048
        ]);

        $file = $request->file('file');
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

        $path = Storage::disk('public')->putFileAs('uploads', $file, $filename);

        $newFile = File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'secret_key' => Str::random(22),
            // 'slug' => Str::slug($file->getClientOriginalName()),
        ]);

        return redirect()->route('files.index')->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $file = File::find($slug);
        return view('dashboard.files.show', compact('file'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }



    public function downloadFile(Request $request)
    {
        // Validate the request data, including the secret key and file details

        $secretKey = $request->input('secretKey');
        $file = $request->input('file');

        // Check if the entered secret key matches the file's secret key
        if ($secretKey === $file['secret_key']) {
            $filePath = 'uploads/' . $file['filename'];
            // Get the file from the storage and return it as a download response
            if (Storage::exists($filePath)) {
                return response()->download(storage_path('app/' . $filePath), $file['filename'], [
                    'Content-Type' => 'application/pdf',
                ]);
            }
        }

        // If the secret key is incorrect or the file does not exist, return an error response
        return response()->json(['message' => 'Error: File not found.'], 404);
    }
}
