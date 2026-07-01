<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\ChapterList;
use App\Models\CustomFolder;
use App\Models\CustomStatus;
use App\Models\Folder;
use App\Models\Media;
use App\Models\MediaProvider;
use App\Models\MediaType;
use App\Models\Provider;
use App\Models\ReadingSpot;
use App\Models\ReadingSpotUse;
use App\Models\ScrapingScript;
use App\Models\ScrapingType;
use App\Models\Status;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserMediaList;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Scraping Types
        $scrapingTypes = ['search_manga', 'latest_updates', 'get_chapters', 'get_chapter_pages', 'non_script'];
        foreach ($scrapingTypes as $typeName) {
            ScrapingType::firstOrCreate(['name' => $typeName]);
        }

        // Seed Statuses
        $statusNames = ['Plan to Watch', 'Watching', 'Completed', 'On Hold', 'Dropped'];
        foreach ($statusNames as $statusName) {
            Status::firstOrCreate(['name' => $statusName]);
        }

        // Seed Standard Folders
        $folderNames = ['Reading', 'Wishlist', 'Completed', 'Favorites', 'Archive'];
        foreach ($folderNames as $folderName) {
            Folder::firstOrCreate(['name' => $folderName]);
        }

        // Seed Providers
        $providers = [['name' => 'asurascans', 'uri' => '.com'], ['name' => 'qimanga', 'uri' => '.com'], ['name' => 'utoon', 'uri' => '.net'], ['name' => 'lagoonscans', 'uri' => '.com'], ['name' => 'magustoon', 'uri' => '.org']];
        foreach ($providers as $providerName) {
            Provider::firstOrCreate(['name' => $providerName['name']], [
                'logo' => 'https://via.placeholder.com/100x100?text=' . urlencode($providerName['name']),
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $providerName['name'])) . $providerName['uri'],
                'online' => true,
            ]);
        }

        // Seed Scraping Scripts
// $scripts = [
//     // AsuraScans
//     ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-search_manga.py', 'scraping_type_id' => 1],
//     ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-latest_updates.py', 'scraping_type_id' => 2],
//     ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-get_chapters.py', 'scraping_type_id' => 3],
//     ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-get_chapter_pages.py', 'scraping_type_id' => 4],

//     // QiManga
//     ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-search_manga.py', 'scraping_type_id' => 1],
//     ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-latest_updates.py', 'scraping_type_id' => 2],
//     ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-get_chapters.py', 'scraping_type_id' => 3],
//     ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-get_chapter_pages.py', 'scraping_type_id' => 4],

//     // UToon
//     ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-search_manga.py', 'scraping_type_id' => 1],
//     ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-latest_updates.py', 'scraping_type_id' => 2],
//     ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-get_chapters.py', 'scraping_type_id' => 3],
//     ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-get_chapter_pages.py', 'scraping_type_id' => 4],
// ];

$asura_scripts = [
    ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-search_manga.py', 'scraping_type_id' => 1, "provider_id" => 1],
    ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-latest_updates.py', 'scraping_type_id' => 2, "provider_id" => 1],
    ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-get_chapters.py', 'scraping_type_id' => 3, "provider_id" => 1],
    ['file' => 'asurascans-a3f5b721-e730-4eb6-928d-2a106f3647f3-get_chapter_pages.py', 'scraping_type_id' => 4, "provider_id" => 1]
];

$qimanga_scripts = [
    ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-search_manga.py', 'scraping_type_id' => 1, "provider_id" => 2],
    ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-latest_updates.py', 'scraping_type_id' => 2, "provider_id" => 2],
    ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-get_chapters.py', 'scraping_type_id' => 3, "provider_id" => 2],
    ['file' => 'qimanga.com-b7277335-8164-4c5f-8a68-1b22fb90f423-get_chapter_pages.py', 'scraping_type_id' => 4, "provider_id" => 2]
];

$utoon_scripts = [
    ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-search_manga.py', 'scraping_type_id' => 1, "provider_id" => 3],
    ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-latest_updates.py', 'scraping_type_id' => 2, "provider_id" => 3],
    ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-get_chapters.py', 'scraping_type_id' => 3, "provider_id" => 3],
    ['file' => 'utoon-8f3a7b9e-4c2d-4f1a-9d6b-7e5c2a1f8b34-get_chapter_pages.py', 'scraping_type_id' => 4, "provider_id" => 3]
];

$magus_scripts = [
    ['file' => 'magustoon-9b8e72c5-39fd-4f76-bc3a-9694c9be1350-search_manga.py', 'scraping_type_id' => 1, "provider_id" => 5],
    ['file' => 'magustoon-9b8e72c5-39fd-4f76-bc3a-9694c9be1350_updates.py', 'scraping_type_id' => 2, "provider_id" => 5],
    ['file' => 'magustoon-9b8e72c5-39fd-4f76-bc3a-9694c9be1350-get_chapters.py', 'scraping_type_id' => 3, "provider_id" => 5],
    ['file' => 'magustoon-9b8e72c5-39fd-4f76-bc3a-9694c9be1350-get_chapter_pages.py', 'scraping_type_id' => 4, "provider_id" => 5]
];

$lagoon_scripts = [
    ['file' => 'lagoonscans-e74b3d32-d872-4753-9a3b-2856bb7b1d6f-search_manga.py', 'scraping_type_id' => 1, "provider_id" => 4],
    ['file' => 'lagoonscans-e74b3d32-d872-4753-9a3b-2856bb7b1d6f-latest_updates.py', 'scraping_type_id' => 2, "provider_id" => 4],
    ['file' => 'lagoonscans-e74b3d32-d872-4753-9a3b-2856bb7b1d6f-get_chapters.py', 'scraping_type_id' => 3, "provider_id" => 4],
    ['file' => 'lagoonscans-e74b3d32-d872-4753-9a3b-2856bb7b1d6fget_chapter_pages.py', 'scraping_type_id' => 4, "provider_id" => 4]
];

    foreach ($asura_scripts as $ascript){
        $script = ScrapingScript::firstOrCreate($ascript);
        // $script->providers()->attach(1);
    }

        foreach ($qimanga_scripts as $qscript){
        $script = ScrapingScript::firstOrCreate($qscript);
        // $script->providers()->attach(2);
    }

        foreach ($utoon_scripts as $uscript){
        $script = ScrapingScript::firstOrCreate($uscript);
        // $script->providers()->attach(3);
    }

        foreach ($magus_scripts as $mscript){
        $script = ScrapingScript::firstOrCreate($mscript);
        // $script->providers()->attach(5);
    }

        foreach ($lagoon_scripts as $lscript){
        $script = ScrapingScript::firstOrCreate($lscript);
        // $script->providers()->attach(4);
    }



        $mediaData = Storage::json('data/filtered_media.json');

        $this->seedMediaFromJson($mediaData);


        // Seed Users with related data
        $users = User::factory(10)->create();
        $allMedia = Media::all();

        foreach ($users as $user) {
            // Create user settings
            UserSetting::factory()->create(['user_id' => $user->id]);

            // Create custom statuses for user
            CustomStatus::factory()->count(3)->create(['user_id' => $user->id]);

            // Create custom folders for user
            CustomFolder::factory()->count(2)->create(['user_id' => $user->id]);

            // Create reading spots for user
            if ($allMedia->count() > 0) {
                ReadingSpot::factory()->count(rand(2, 5))->create(['user_id' => $user->id]);

                // Create reading spot uses
                $userReadingSpots = ReadingSpot::where('user_id', $user->id)->get();
                foreach ($userReadingSpots as $spot) {
                    ReadingSpotUse::factory()->count(rand(1, 3))->create([
                        'user_id' => $user->id,
                        'reading_spot_id' => $spot->id,
                    ]);
                }
            }
        }

        // Add a test user
        $user = User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $asura = Storage::json('data/matched_media_asura.json');
        $this->seedMediaProviderListFromJson($asura);

        $lagoon = Storage::json('data/lagoon_matched.json');
        $this->seedMediaProviderListFromJson($lagoon);

        $utoon = Storage::json('data/utoon_matched.json');
        $this->seedMediaProviderListFromJson($utoon);

        $qimanga = Storage::json('data/matched_items_qimanga.json');
        $this->seedMediaProviderListFromJson($qimanga);


        $user->media()->attach(12, ['folder_id' => 1]);
        $user->media()->attach(156, ['folder_id' => 1]);
        $user->media()->attach(882, ['folder_id' => 1]);
        $user->media()->attach(942, ['folder_id' => 1]);
        $user->media()->attach(38, ['folder_id' => 1]);

        $this->seedChapters();

    }

    private function seedMediaProviderListFromJson($json){
        ini_set('memory_limit', '512M');//allocate memory
        DB::disableQueryLog();//disable log

        MediaProvider::insert($json);

    }

    private function seedMediaFromJson($json){
        ini_set('memory_limit', '512M');//allocate memory
        DB::disableQueryLog();//disable log

        $media_types = ['manwha','manga','manhua'];

        foreach ($media_types as $type){
            MediaType::firstOrCreate(['name' => $type]);
        }

        $data = collect($json);

        $chunks = $data->chunk(1000);

        foreach ($chunks as $key => $d) {
          DB::table('media')->insert($d->toArray());
      }
    }

    /**
     * Method to fill known chapters
     */
    private function seedChapters()
    {

        $chapters = Storage::json('chapters/chapters_lists.json');

        $cleaned = collect($chapters)->filter(function($value,$key) {
            return !array_key_exists("error",$value);
        })->map(function($value,$key){

            $arr = collect($value["chapters"])->map(function($chapter) use ($key){

                if (preg_match('/(\d+)$/', $chapter['chapter_url'], $matches)) {
                    $number = $matches[1];
                } else {
                    $number = null; // No trailing number found
                }

                return [
                    "name" => $number != null ? $number : $chapter['chapter_title'],
                    "chapter" => $chapter['chapter_url'],
                    "media_provider_id" => $key
                ];
            });
            return $arr;
        });

        foreach($cleaned as $key => $chapterList){

            ChapterList::insert($chapterList->toArray());

        }
    }


    /**
     * Seed media from CSV file
     */
    private function seedMediaFromCsv(string $csvPath): void
    {
        $file = fopen($csvPath, 'r');
        $headers = fgetcsv($file);

        $mediaCount = 0;
        $maxMedia = 500;

        while (($row = fgetcsv($file)) !== false && $mediaCount < $maxMedia) {
            $data = array_combine($headers, $row);

            // Parse volumes
            $volumes = null;
            if (isset($data['Volumes']) && $data['Volumes'] !== '?' && $data['Volumes'] !== null && !empty($data['Volumes'])) {
                $volumes = (int) $data['Volumes'];
            }

            // Parse published year
            $publishedYear = null;
            if (isset($data['year']) && !empty($data['year'])) {
                $publishedYear = (int) $data['year'];
            }

            // Get or create media type
            $mediaTypeName = $data['Type'] ?? 'Manga';
            $mediaType = MediaType::firstOrCreate(['name' => $mediaTypeName]);

            // Create or update media
            $media = Media::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'] ?? null,
                    'published_year' => $publishedYear,
                    'cover' => $data['image_url'] ?? $data['cover'] ?? null,
                    'volumes' => $volumes,
                    'media_type_id' => $mediaType->id,
                ]
            );

            // Parse and attach tags
            if (isset($data['tags']) && !empty($data['tags'])) {
                $tagString = $data['tags'];
                // Remove brackets and quotes, then split by comma
                $tagString = str_replace(['[', ']', "'", '"'], '', $tagString);
                $tagNames = array_map('trim', explode(',', $tagString));

                foreach ($tagNames as $tagName) {
                    if (!empty($tagName)) {
                        $tag = Tag::firstOrCreate(['name' => $tagName]);
                        if (!$media->tags()->where('tag_id', $tag->id)->exists()) {
                            $media->tags()->attach($tag->id);
                        }
                    }
                }
            }

            // Attach random providers
            $randomProviders = Provider::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            foreach ($randomProviders as $providerId) {
                if (!$media->providers()->where('provider_id', $providerId)->exists()) {
                    $media->providers()->attach($providerId);
                }
            }

            $mediaCount++;
        }

        fclose($file);
    }
}


