<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Phpml\Classification\KNearestNeighbors;

class AiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:test';

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
     * @return mixed
     */
    public function handle()
    {
        //

        /*
        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'a', 'a', 'a', 'a', 'a'];

        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        

        echo $classifier->predict([3, 2]). PHP_EOL;
        */

        $this->info('Welcome to the area');
        $this->error('Don\'t try to escape');
        $this->line('Display this on the screen');
        $name = $this->ask('What is your name?');
        $password = $this->secret('What is the password?');
        $headers = ['Name', 'Email'];

        $bar = $this->output->createProgressBar(1000000);

        for($i = 0; $i <= 1000000; $i++){
            $bar->advance();
        }
        $bar->finish();
        $this->line('Hola');
        $this->table($headers, [[$name, $password]]);
        
    }
}
