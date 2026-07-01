<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Provider;
use App\Models\Status;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class MediaController extends Controller
{

    /**
     * Method to get json from text
     * @param string $text
     * @return string
     */
    private function getJson($text){
        $pattern = '
                /
                \{              # { character
                    (?:         # non-capturing group
                        [^{}]   # anything that is not a { or }
                        |       # OR
                        (?R)    # recurses the entire pattern
                    )*          # previous group zero or more times
                \}              # } character
                /x
                ';

        preg_match_all($pattern, $text, $matches);
        return $matches[0];
    }


    /**
     * Method to get all manga with authors, tags and providers
     * @param Request $request
     */
    public function index(Request $request)
    {
        $model = new Media();
        $searchVal = $request->search;
        if($searchVal){
            $model = $model->where('title', 'LIKE', '%' . $searchVal . '%');
        }

        $model = $model->with(['type:id,name', 'authors', 'tags', 'providers'])->paginate(20);

        // $media = Media::with(['type:id,name', 'authors', 'tags', 'providers'])->paginate(20);


        return response()->json($model);
    }

    public function addMediaToUserList(Request $request)
    {
        dd($request);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|url',
            'media_type_id' => 'nullable|exists:media_types,id',
            'author_ids' => 'nullable|array',
            'author_ids.*' => 'exists:authors,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
            'provider_ids' => 'nullable|array',
            'provider_ids.*' => 'exists:providers,id',
        ]);

        $media = Media::create($data);

        if (!empty($data['author_ids'])) {
            $media->authors()->sync($data['author_ids']);
        }

        if (!empty($data['tag_ids'])) {
            $media->tags()->sync($data['tag_ids']);
        }

        if (!empty($data['provider_ids'])) {
            $media->providers()->sync($data['provider_ids']);
        }

        return response()->json($media->load(['type', 'authors', 'tags', 'providers']), 201);
    }



    public function show( $id)
    {
        $media = Media::with(["providers" => function($query) use ($id){
        $query->with(["mediaProvider" => function($q) use($id){
            $q->where("media_id", "=", $id)->with(["chapterList"]);
        }]);
    }, 'type', 'authors', 'tags'])->findOrFail($id);

        // $media = Media::with(['type', 'authors', 'tags', 'providers'])->findOrFail($id);


        return response()->json($media);
    }

    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|url',
            'media_type_id' => 'nullable|exists:media_types,id',
            'author_ids' => 'nullable|array',
            'author_ids.*' => 'exists:authors,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
            'provider_ids' => 'nullable|array',
            'provider_ids.*' => 'exists:providers,id',
        ]);

        $media->update($data);

        if (array_key_exists('author_ids', $data)) {
            $media->authors()->sync($data['author_ids'] ?? []);
        }

        if (array_key_exists('tag_ids', $data)) {
            $media->tags()->sync($data['tag_ids'] ?? []);
        }

        if (array_key_exists('provider_ids', $data)) {
            $media->providers()->sync($data['provider_ids'] ?? []);
        }

        return response()->json($media->load(['type', 'authors', 'tags', 'providers']));
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();
        return response()->json(['message' => 'Media deleted']);
    }
}
