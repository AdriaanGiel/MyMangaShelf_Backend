<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Status;
use Illuminate\Http\Request;

class FolderApiController extends Controller
{
    /**
     * Method to get all standard folders
     * @param Request $request
     */
    function index(Request $request){

        $folders = Folder::all();

        return response()->json($folders);
    }

}
