<?php

namespace App\Api\Controllers;

use App\Services\MatchService;
use App\Services\XMLReaderService;
use Illuminate\Http\Request;

class XMLController extends BaseController
{
    protected $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    public function index()
    {
        $responseData = $this->matchService->getAll();
        return response()->json($responseData, 200);
    }
}
