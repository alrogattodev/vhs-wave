<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        return ClientResource::collection(Client::all());
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        return new ClientResource($client);
    }

    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    public function update(StoreClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return new ClientResource($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully.']);
    }
}
