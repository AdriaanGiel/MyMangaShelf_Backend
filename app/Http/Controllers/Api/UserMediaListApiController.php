<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use App\Models\UserMediaList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMediaListApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $data = $user->mediaList()->with(['media','folder','customFolder'])->paginate(20);

        $data->map(function($item, $i) {
            $item->media->folder = $item->folder;
            $item->media->custom_folder = $item->custom_folder;

            return $item;
        });

        return response()->json($data);
    }

    public function search(Request $request){
        $user = $request->user();
        $search = $request->search;

        $data = $user->mediaList()->with(['media' => function($query) use ($search){
            $query->where('title', 'LIKE', '%' . $search . '%');
        },'folder','customFolder'])->paginate(20);


        $data = $data->filter(function($item,$i) {
            return $item->media !== null;
        });

        $data->map(function($item, $i) {
            $item->media->folder = $item->folder;
            $item->media->custom_folder = $item->custom_folder;

            return $item;
        });

        return response()->json($data);

    }


    public function addMediaToUserList(Request $request)
    {
        $user = $request->user();
        $media_id = $request->media_id;
        $folder = collect($request->folder);

        $isCustom = $folder->has("user_id");

        $folder_id = ($isCustom) ? null : $folder["id"];
        $custom_id = ($isCustom) ? $folder["id"] : null;

        $find = DB::table('user_media_list')->where(["user_id" => $user->id, "media_id" => $media_id])->get();

        if($find->isNotEmpty()){
            $first = $find->first();
            if($first->custom_status_id == $custom_id && $first->status_id == $folder_id){
                return response()->json(["message" => "This is already in your library!"], 200);
            }

            DB::table('user_media_list')->update([
            "folder_id" => $folder_id,
            "custom_folder_id" => $custom_id
            ]);

            return response()->json(["message" => "Succesfully changed folders in your list."],200);
        }

        DB::table('user_media_list')->insert([
            "user_id" => $user->id,
            "media_id" => $media_id,
            "folder_id" => $folder_id,
            "custom_folder_id" => $custom_id
        ]);

        return response()->json(["message" => "Succesfully added to your list."],201);
    }


    public function removeMediaFromUserList(Request $request){
        $user = $request->user();
        $media_id = $request->media_id;

        $deleted = DB::table('user_media_list')->where('user_id', '=', $user->id)->where('media_id', '=',$media_id)->delete();

        return response()->json(["message" => "Deleted $media_id"]);
    }

    public function changeUserMediaFolderType(Request $request){

    }
}
