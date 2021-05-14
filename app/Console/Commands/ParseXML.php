<?php

namespace App\Console\Commands;

use App\Services\MatchService;
use App\Services\XMLReaderService;
use Illuminate\Console\Command;

class ParseXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:xml {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse xml into json and insert them into database';

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
    public function handle(XMLReaderService $readerService, MatchService $matchService)
    {
        $contentArray = $readerService->readToArray($this->argument('filename'));
        $matchService->saveOrUpdateMatch($contentArray["match"]);
    }
}
