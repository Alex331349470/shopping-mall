<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\GpsBasicDataRequest;
use App\Http\Resources\GpsBasicDataResource;
use App\models\GpsBasicData;
use Illuminate\Http\Request;

class GpsBasicDataController extends Controller
{
    public function index()
    {
        $data = GpsBasicData::paginate(10);

        GpsBasicDataResource::wrap('data');
        return GpsBasicDataResource::collection($data);

    }
    public function store(GpsBasicDataRequest $request,GpsBasicData $gpsBasicData)
    {
        $data = $gpsBasicData->create($request->all());

        GpsBasicDataResource::wrap('data');
        return new GpsBasicDataResource($data);

    }

    public function show(GpsBasicData $gpsBasicData)
    {
        return new GpsBasicDataResource($gpsBasicData);
    }

    public function update(GpsBasicDataRequest $request, GpsBasicData $gpsBasicData)
    {
        $gpsBasicData->update($request->all());
        return new GpsBasicDataResource($gpsBasicData);
    }

    public function destroy(GpsBasicData $gpsBasicData)
    {
        $gpsBasicData->delete();
        return response(null,204);
    }
}
