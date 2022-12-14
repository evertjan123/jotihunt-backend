<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Clubhouse;

class getClubhouses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:clubHouses';

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
        $this->info('retrieving clubhouses');
        $response = Http::get('https://jotihunt.nl/api/2.0/subscriptions');

        $clubhouses = json_decode($response->body())->data;
        $this->info('retrieved ' . count($clubhouses) . " clubhouses");
        Clubhouse::truncate();
        array_map(function ($house) {
            Clubhouse::updateOrCreate(['name' => $house->name,
                                'accomodation' => $house->accomodation,
                                'street' => $house->street,
                                'housenumber' => $house->housenumber,
                                'housenumber_addition' => $house->housenumber_addition,
                                'postcode' => $house->postcode,
                                'city' => $house->city,
                                'lat' => $house->lat,
                                'long' => $house->long,
                                'photo_assignment_points' => $house->photo_assignment_points,
                                'area' => $house->area]);
        }, $clubhouses);

        $this->info('saved clubhouses');

    }
}
