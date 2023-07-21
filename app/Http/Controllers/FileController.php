<?php

namespace App\Http\Controllers;

use App\Http\Requests\DawonloadFileRequest;
use App\Http\Requests\FileRequest;
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
    public function store(FileRequest $request)
    {
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
    public function show($id)
    {
        $file = File::find($id);
        return view('dashboard.files.show', compact('file'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

         $file = File::findOrFail($id);

         return view('dashboard.files.edite',compact('file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $request, $id)
    {
        $file = File::findOrFail($id);

        if ($request->hasFile('file')) {
            $newFile = $request->file('file');
            $filename = Str::random(20) . '.' . $newFile->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('uploads', $newFile, $filename);

            // Remove the old file
            Storage::disk('public')->delete($file->path);

            // Update the file information
            $file->filename = $newFile->getClientOriginalName();
            $file->path = $path;
            $file->mime_type = $newFile->getClientMimeType();
            $file->size = $newFile->getSize();
        }
        $file->save();

        return redirect()->route('files.index')->with('success', 'File updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // if ($file->path) {
            Storage::disk('public')->delete($file->path);
        // }

        $file->delete();

        return redirect()->route('files.index')->with('success','File Deleted Successfully');
    }




    public function downloadFile(DawonloadFileRequest $request)
    {

        $secretKey = $request->input('secretKey');
        $fileId = $request->input('fileId');

        $file = File::find($fileId);

        if ($file && $secretKey === $file->secret_key) {
            $filePath = $file->path;

            if (Storage::disk('public')->exists($filePath)) {
                $originalFilename = $file->filename;

                $fileContents = Storage::disk('public')->get($filePath);

                $fileMimeType = $file->mime_type;

                $allowedMimeTypes = [
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                ];

                if (in_array($fileMimeType, $allowedMimeTypes)) {
                    return response($fileContents, 200, [
                        'Content-Type' => $fileMimeType,
                        'Content-Disposition' => 'attachment; filename="' . $originalFilename . '"',
                    ]);
                }
            }
        }

        // redirect to show file page with  error flash message

        return redirect()->back()->with('error', 'Error: File not found or access denied.');
    }


}


