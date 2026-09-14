<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('tvip:about', function (): void {
    $this->info('TVIP Company Profile, fase Home single page.');
})->purpose('Menampilkan informasi singkat project TVIP');
