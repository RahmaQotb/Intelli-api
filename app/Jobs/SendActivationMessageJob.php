<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendActivationMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $brand;
    private $status;
    /**
     * Create a new job instance.
     */
    public function __construct($brand, $status)
    {
        $this->brand = $brand;
        $this->status = $status;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
     sendMail($this->brand->brand_admin->email, 'meow', 'Brand Activation', [
            'brand_name' => $this->brand->name,
            'status' => $this->status ? 'activated' : 'deactivated',
        ]);
        info('Activation message sent for brand: ' . $this->brand->name);   
    }
}
