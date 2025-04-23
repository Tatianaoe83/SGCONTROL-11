<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use App\Services\DatabaseSearchService;
use App\Services\StorageSearchService;
use Illuminate\Http\Request;

class ChatSearchController extends Controller
{
    protected $aiService;
    protected $databaseSearch;
    protected $storageSearch;

    public function __construct(AIService $aiService, DatabaseSearchService $databaseSearch, StorageSearchService $storageSearch)
    {
        $this->aiService = $aiService;
        $this->databaseSearch = $databaseSearch;
        $this->storageSearch = $storageSearch;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // La IA entiende lo que quiere el usuario
        $aiResponse = $this->aiService->chat($query);

        // Luego hacemos las búsquedas internas
        $dbResults = $this->databaseSearch->search($query);
        $fileResults = $this->storageSearch->searchInFiles($query);

        return response()->json([
            'aiResponse' => $aiResponse,
            'dbResults' => $dbResults,
            'fileResults' => $fileResults,
        ]);
    }
}