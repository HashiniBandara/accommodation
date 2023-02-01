<?php

namespace App\Console\Commands;

use App\Model\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $jsonPath = 'https://restcountries.com/v3.1/all';
        $jsonText = file_get_contents($jsonPath);
        $countries = json_decode($jsonText, false);


        DB::transaction(function () use ($countries){
            DB::table('countries')->truncate();
            foreach ($countries as $country){
                try{
                    $c = new Country();
                    $c->name = $country->name->common;
                    $c->flag = $country->flags->png;
                    $c->phone_prefix = $country->idd->root.implode("", $country->idd->suffixes);
                    $c->save();
                }catch (\Exception $e){

                }
            }
        });

        return Command::SUCCESS;
    }
}
