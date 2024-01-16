<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FileController extends Controller
{
    public function indexFiles(Request $request):Response{
        return Inertia::render('File/Index', [
            'data'=>File::paginate(10)
        ]);
    }

    public function createFiles(Request $request):Response{
        return Inertia::render('File/Create/Index');
    }


    public function storeFiles(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'images'=>'required|array'
        ]);

        $images = [];

        foreach($data['images'] as $image){
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image_path = $image->storeAs('images', $fileName, 'public');  // 파일 경로, 이름, 디스크
            array_push($images, $image_path);
        }

        $data['images'] = $images;

        File::create($data);
        return Inertia::location(route('files.index'));
    }
}
