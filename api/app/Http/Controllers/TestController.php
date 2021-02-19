<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function tenantTest()
    {
        return 'tenant';
    }

    public function uploadFile(Request $request)
    {
        $path = $request->file('image');
        $imageName = $path->getClientOriginalName();
        $img = Storage::disk('s3')->put('test/img', $path);
    }
}
