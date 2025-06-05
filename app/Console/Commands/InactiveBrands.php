<?php

namespace App\Console\Commands;

use App\Jobs\SendActivationMessageJob;
use App\Models\Brand;
use Illuminate\Console\Command;

class InactiveBrands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inactive-brands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'inactive brands command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $brands = Brand::where('status', false)->get();
        if ($brands->isEmpty()) {
            $this->info('No inactive brands found.');
            return;
        }
        foreach($brands as $brand)
        {   
            info('command');
            $this->info('Brand ID: ' . $brand->id);
            $this->info('Brand Name: ' . $brand->name);
            dispatch(new SendActivationMessageJob($brand , $brand->status))->onQueue('emails');
        }
    }
}
