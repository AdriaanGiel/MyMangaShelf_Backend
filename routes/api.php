<?php

use App\Http\Controllers\Api\FolderApiController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\CustomFolderApiController;
use App\Http\Controllers\Api\ScriptController;
use App\Http\Controllers\Api\UserMediaListApiController;
use App\Http\Controllers\Api\UserMediaListController;
use App\Models\Generation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('media', MediaController::class);

Route::post('get-chapters', [ScriptController::class, 'getChapters']);


Route::get('folders', [FolderApiController::class, "index"]);
Route::get('provider', [ProviderController::class,"index"]);

Route::middleware('auth:sanctum')->group(function (){


    Route::get('user-media-list', [UserMediaListApiController::class, "index"]);
    Route::delete('user-media-list/remove', [UserMediaListApiController::class, "removeMediaFromUserList"]);
    Route::put('user-media-list/change', [UserMediaListApiController::class, "changeUserMediaFolderType"]);
    Route::post('user-media-list/add', [UserMediaListApiController::class, "addMediaToUserList"]);
    Route::post('user-media-list/search', [UserMediaListApiController::class, "search"]);

    Route::post('get-updates', function (Request $request){
        $id = $request->gen_id;
        $generation = Generation::findOrFail($id);

        return response()->json(["status" => $generation->status]);
    });


    Route::apiResource('user-folders', CustomFolderApiController::class);


    Route::apiResource('user-media-api', UserMediaListController::class);

    Route::post('provider',[ProviderController::class,"store"]);
});


Route::post('/register', function (Request $request) {
    $request -> validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed:confirm_password',
        'confirm_password' => 'required '
    ]);

    $user = User::create([
        "name" => $request-> name,
        "email" => $request->email,
        "password" => Hash::make($request->password)
    ]);

    return response()->json($user,201);

});

Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $request["device_name"] = 'mobile';

    $user = User::where('email', $request->email,)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user->only('id','name','email')
    ],201);
});

Route::middleware('auth:sanctum')->post('/logout',function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json('logged out successfully');
});
