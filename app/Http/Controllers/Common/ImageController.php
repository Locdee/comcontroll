<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    //
    public function save(Request $request){
        $path = $request->file('file')->store('uploads');

        return ajaxResponse('保存成功',1,'/'.$path);

    }
}
