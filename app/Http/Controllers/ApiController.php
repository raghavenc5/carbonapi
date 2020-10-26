<?php

namespace App\Http\Controllers;

use App\ApiData;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\ApiResource;
use Validator;
use App\Http\Controllers\BaseController as BaseController;

class ApiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApiData::all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Get all GET,POST request from the URL
        $input = request()->all();
        
        //Validation of the parameters is required to run the API store function
        $validator = Validator::make($input, [
            'activity' => 'required',
            'activityType' => 'required',
            'country' => 'required',
            'fuelType' => 'required',
            'mode' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        try{

            $activity = $input['activity'] ?? '';
            $activityType = $input['activityType'] ?? '';
            $country = $input['country'] ?? '';
            $fuelType = $input['fuelType'] ?? '';
            $mode = $input['mode'] ?? '';
            //$AppTkn = "1234";

            //Create Client object to call the Carbon API to retrieve the data  
            $client = new Client();

            $response = $client->request('GET', 'https://api.triptocarbon.xyz/v1/footprint?activity='.$activity.'&activityType='.$activityType.'&country='.$country.'&fuelType='.$fuelType.'&mode='.$mode);
            
            $statusCode = $response->getStatusCode();
            $content = $response->getBody()->getContents();
            //Decode the json response to get in array format
            $data = json_decode($content,true);

            //Store the Api Data to the DB table
            $api_data = ApiData::create([
                'activity' => $activity,
                'activityType' => $activityType,
                'country' => $country,
                'fuelType' => $fuelType,
                'mode' => $mode,
                'carbonFootprint' => $data['carbonFootprint']
              ]);
            
            //Add Data to the Resource 
            new ApiResource($api_data);

            //Cache the API response for 1 Day
            //Cache::put('ApiDataUrls', $content, 86400);
            Cache::remember('urls', 86400, function(){ return ApiData::all(); });

            return $this->sendResponse($api_data->toArray(), 'Data retrieved successfully.');

        } catch (\Exception $e){
            return $e->getMessage();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $api_data = ApiData::findOrFail($id);
        return $api_data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $api_data = ApiData::findOrFail($id);
        $api_data->delete();

        return $this->sendResponse($api_data->toArray(), 'Data deleted successfully.');
    }

    public function saved()
    {
        $data = Cache::get('urls');
        return $data;
    }
}
