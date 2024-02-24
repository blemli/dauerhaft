<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowCommand extends Command
{
    protected $signature = 'show';
    protected $description = 'Open the application\'s base URL in the browser';

    public function handle()
    {
        // Fetch the application URL from config
        $url = config('app.url');

        // Detect the operating system
        $os = strtolower(PHP_OS);

        if (strpos($os, 'darwin') !== false) { // macOS
            exec("open $url");
        } elseif (strpos($os, 'win') !== false) { // Windows
            exec("start $url");
        } elseif (strpos($os, 'linux') !== false) { // Linux
            exec("xdg-open $url");
        } else {
            $this->error("Your OS is not supported.");
            return 1;
        }

        $this->info("Opening $url in your default browser...");
        return 0;
    }
}
