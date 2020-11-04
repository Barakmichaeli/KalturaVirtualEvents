<?php

namespace App\Http\Controllers\Entries;

use App\Kaltura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Controller extends \App\Http\Controllers\Controller {
    
    /**
     * no pagination needed for such small number of entries.
     * in case of a big entries grid, we could get $entries_page + $entries_count and implement server-side pagination..
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatest() {
        $kaltura = new Kaltura();
        return response()->json([
            'entries' => $kaltura->getLatestEntries()
        ]);
    }
    
    public function searchLatestEntry(Request $request) {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => "INVALID_SEARCH_KEYWORD",
            ]);
        }
        $keyword = $request->get('keyword');
        $kaltura = new Kaltura();
        return response()->json([
            'results' => $kaltura->searchLatestEntry($keyword),
        ]);
    }
}
