<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlateData;
use Http;

class PlateDataController extends Controller
{
    public function plateToVin(Request $request)
    {
        $plate = $request->plate;
        $state = $request->state;

        // Check if we already have this record locally
        $localData = PlateData::where('plate_number', $plate)
            ->where('state', $state)
            ->first();

        if ($localData) {
            return response()->json([
                'source' => 'local',
                'success' => true,
                'vin' => [
                    'vin' => $localData->vin,
                    'year' => $localData->year,
                    'make' => $localData->make,
                    'model' => $localData->model,
                    'trim' => $localData->trim,
                    'name' => $localData->name,
                    'engine' => $localData->engine,
                    'style' => $localData->style,
                    'transmission' => $localData->transmission,
                    'driveType' => $localData->drive_type,
                    'fuel' => $localData->fuel,
                    'color' => [
                        'name' => $localData->color_name,
                        'abbreviation' => $localData->color_abbreviation,
                    ],
                ],
            ]);
        }

        // No local record, so make the API call
        $response = Http::withHeaders([
            'Authorization' => env('PLATE_TO_VIN_API_KEY'),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ])->post('https://platetovin.com/api/convert', [
            'state' => $state,
            'plate' => $plate,
        ]);

        $result = $response->json();



        if ($result['success'] && isset($result['vin'])) {
            $vinData = $result['vin'];
            \Log::info($vinData);
            $result['source'] = 'API';

            // Store the data locally. Ensure that your migration and model allow these fields.
            PlateData::create([
                'plate_number'       => $plate,
                'state'              => $state,
                'vin'                => $vinData['vin'],
                'year'               => $vinData['year'],
                'make'               => $vinData['make'],
                'model'              => $vinData['model'],
                'trim'               => $vinData['trim'],
                'name'               => $vinData['name'],
                'engine'             => $vinData['engine'],
                'style'              => $vinData['style'],
                'transmission'       => $vinData['transmission'],
                'drive_type'         => $vinData['driveType'],
                'fuel'               => $vinData['fuel'],
                'color_name'         => $vinData['color']['name'],
                'color_abbreviation' => $vinData['color']['abbreviation'],
            ]);
        }

        return response()->json($result);
    }
}
