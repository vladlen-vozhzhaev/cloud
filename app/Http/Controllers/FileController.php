<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    function loadFile(Request $request){
        $user = auth()->user();
        $userfiles = $request->file('userfile');
        foreach ($userfiles as $userfile){
            $size = round($userfile->getSize()/1024, 2);
            $fileName = $userfile->getClientOriginalName();
            $fileType = $userfile->extension();
            $path = $userfile->store('userfiles/'.$user->getAuthIdentifier());
            $file = new UserFile();
            $file->filename = $fileName;
            $file->user_id = $user->getAuthIdentifier();
            $file->file_size = $size;
            $file->file_type = $fileType;
            $file->file_path = $path;
            $file->save();
        }
        return redirect()->intended('/dashboard');
    }

    function showDashboard(){
        $user = auth()->user();
        $files = UserFile::where('user_id', $user->getAuthIdentifier())->get();
        return view('dashboard', ['files'=>$files]);
    }

    function downloadFile(Request $request){
        $fileId = $request->id;
        $userfile = UserFile::where('id', $fileId)->first();
        $userId = auth()->user()->getAuthIdentifier();
        if($userfile->user_id == $userId){
            return Storage::download($userfile->file_path, $userfile->filename);
        }else{
            return "Доступ к этому файлу запрещён";
        }
    }
}
