<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Area;

class getAreas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:Areas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('retrieving areas');
        $response = Http::get('https://jotihunt.nl/api/2.0/areas');

        $areas = json_decode($response->body())->data;
        $this->info('retrieved ' . count($areas) . " areas");

        array_map(function ($area) {
            Area::updateOrCreate(["name" => $area->name], ['name' => $area->name,
                                'status' => $area->status,
                               ]);
        }, $areas);

        $this->info('saved areas');
    }
}
