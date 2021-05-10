<?php

namespace App\Api\Controllers;

use App\Services\MatchService;
use App\Services\XMLReaderService;
use Illuminate\Http\Request;

class XMLController extends BaseController
{
    protected $readerService;
    protected $matchService;

    public function __construct(XMLReaderService $readerService, MatchService $matchService)
    {
        $this->readerService = $readerService;
        $this->matchService = $matchService;
    }

    public function index()
    {
        dd($this->matchService->getAll());
    }

    /**
     * Read the xml file and convert it to an array and save into the database.
     *
     */
    public function insertXmlDb()
    {
        $contentArray = $this->readerService->readToArray('feed.xml');
        $this->matchService->saveOrUpdateMatch($contentArray["match"]);
        dd($contentArray);
    }
}
