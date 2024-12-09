<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Media;
use App\Models\Rental;
use App\Jobs\ProcessMediaRental;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{

    public function rent(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'media_id' => 'required|exists:medias,id',
        ]);

        $media = Media::find($validated['media_id']);

        if (!$media->availability) {
            return response()->json(['message' => 'Media is not available'], 400);
        }

        ProcessMediaRental::dispatch($validated['client_id'], $validated['media_id']);

        return response()->json(['message' => 'Rental process initiated.']);
    }

    public function return(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->returned_at) {
            return response()->json(['message' => 'Media already returned'], 400);
        }

        $rental->update(['returned_at' => Carbon::now()]);

        $rental->media->update(['availability' => true]);

        return response()->json(['message' => 'Media returned successfully', 'rental' => $rental]);
    }
}