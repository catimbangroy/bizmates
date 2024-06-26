<?php

namespace App\Http\Controllers;

use App\Services\PlaceService;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function __construct(protected PlaceService $placeService)
    {

    }

    public function index(Request $request)
    {
        return $this->placeService->getPlaces($request->data);
    }
}
