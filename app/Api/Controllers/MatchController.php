<?php

namespace App\Api\Controllers;

use App\Api\Controllers\BaseController;
use App\Services\MatchService;
use Illuminate\Http\Request;

class MatchController extends BaseController
{
    /**
     * @var MatchService
     */
    private $matchService;

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
