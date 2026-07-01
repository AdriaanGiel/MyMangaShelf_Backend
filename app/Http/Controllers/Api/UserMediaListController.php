<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMediaList;
use Illuminate\Http\Request;

class UserMediaListController extends Controller
{
    public function index()
    {
        $lists = UserMediaList::with(['user', 'media', 'status', 'customStatus'])->paginate(20);
        return response()->json($lists);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'media_id' => 'required|exists:media,id',
            'folder_id' => 'required|exists:statuses,id',
            'custom_folder_id' => 'nullable|exists:custom_statuses,id',
        ]);

        $item = UserMediaList::create($data);

        return response()->json($item->load(['user', 'media', 'status', 'customStatus']), 201);
    }

    public function show($id)
    {
        $item = UserMediaList::with(['user', 'media', 'status', 'customStatus'])->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = UserMediaList::findOrFail($id);

        $data = $request->validate([
            'status_id' => 'sometimes|required|exists:statuses,id',
            'custom_status_id' => 'nullable|exists:custom_statuses,id',
        ]);

        $item->update($data);
        return response()->json($item->load(['user', 'media', 'status', 'customStatus']));
    }

    public function destroy($id)
    {
        $item = UserMediaList::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'User media list entry deleted']);
    }
}
