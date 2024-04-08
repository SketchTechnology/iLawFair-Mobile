<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PublishingHouseResource;
use Illuminate\Http\Request;
use App\Models\PublishingHouse;


class PublishingHouseController extends Controller
{
    public function booksByPublishingHouse(PublishingHouse $publishingHouse)
    {
        $books = $publishingHouse->books;
        return response()->json($books);
    }

    public function index()
    {
        $publishingHouses = PublishingHouse::all();
        $publishingHousesResource = PublishingHouseResource::collection($publishingHouses);
        return ApiResponse::sendResponse(200, 'Publishing houses retrieved successfully', $publishingHousesResource);
    }


    public function search(Request $request)
    {
        $query = $request->get('query');

        $publishingHouses = PublishingHouse::where('name', 'like', "%$query%")
                    ->get();

        $publishingHousesResource = PublishingHouseResource::collection($publishingHouses);

        return ApiResponse::sendResponse(200, 'Publishing houses retrieved successfully', $publishingHousesResource);
    }

    

}
