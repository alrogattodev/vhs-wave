<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;

class IncreaseMediaPrice extends Command
{
    protected $signature = 'media:increase-price';
    protected $description = 'Increase the price of all media by 1 cent every 3 minutes';

    public function handle()
    {
        Media::query()->increment('price', 0.01);
        $this->info('Prices increased by 1 cent for all media.');
    }
}

