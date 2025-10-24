<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TripService;
use App\Http\Requests\StoreTripRequest;

class TripController extends Controller
{
    public function __construct(
        protected TripService $tripService,
    ){}

    public function index()
    {
        //
    }

    public function store(StoreTripRequest $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(StoreTripRequest $request, string $id)
    {
        //
    }
}
