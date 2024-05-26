<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //
    public function fileUpload()
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request){
        // dump($request->berkas);
        // dump($request->file('file'));
        // return "Pemrosesan file upload di sini";
        $request->validate([
            'berkas'=>'required|file|image|max:500',]);
            $path = $request->berkas->store('uploads');
            echo "proses upload berhasil, file berada di: $path";
            // echo $request->berkas->getClientOriginalName(). "lolos validasi";
    }
}
