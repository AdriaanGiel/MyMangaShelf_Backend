<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomStatus;
use Illuminate\Http\Request;

class CustomFolderApiController extends Controller
{

    /**
     * index
     * Method to get custom folders
     * @param  mixed $request
     * @return void
     */
    function index(Request $request)
    {
        $user = $request->user();
        return response()->json(["folders" => $user->customStatuses]);
    }

    /**
     * store
     * Method to create custom folder
     * @param  mixed $request
     * @return void
     */
    function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:custom_statuses',
        ]);

        $user = $request->user();

        $folder = $user->createCustomStatus($data);

        return response()->json(["message" => "New folder $folder->name was created"]);
    }


    /**
     * update
     * Method to edit custom folder
     * @param  mixed $request
     * @param  mixed $id
     * @return void Message
     */
    function update(Request $request, $id)
    {
        $user = $request->user();
        $status = $user->customStatuses()->where("id", $request->id)->first();

        $request->validate([
            "name" => "unique:custom_statuses"
        ]);

        $status->updateOrFail(["name" => $request->name]);

        return response()->json(["message" => "Updated folder names"]);

    }



    /**
     * destroy
     * Method to remove custom folder
     * @param  mixed $request
     * @param  mixed $id
     * @return void Message
     */
    function destroy(Request $request, $id)
    {
        $user = $request->user();
        $status = $user->customStatuses()->where("id", $request->id)->first();

        $status->delete();

        return response()->json(["message" => "Folder Deleted"]);
    }


}
