<?php


namespace App\Http\Controllers\Api;

use App\Household;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Household as HouseholdResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class HouseholdController extends BaseController
{
/*
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
    public function index()
    {
        return $this->sendResponse(HouseholdResource::collection(Household::all()), 'Data fetched successfully');
    }


    public function store(Request $request)
    {
        $household = new Household();

        if ($this->storePUTData($request, $household)) {
            return $this->sendResponse(new HouseholdResource($household), 'Household Added successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unable to save data']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $household = Household::findOrfail($id);

            return $this->sendResponse(new HouseholdResource($household), 'Data fetched successfully');

        } catch (ModelNotFoundException  $e) {

            return $this->sendError('NotFoundException', ['We did not find that id!']);
        }
    }

    /**
     * @param Request $request
     * @param Household $household
     * @return mixed
     */
    public function update(Request $request, Household $household)
    {
        return $this->storePUTData($request,$household);
    }


    public function destroy(Household $household): \Illuminate\Http\Response
    {
        //
        if ($household->delete()) {

            return $this->sendResponse(new HouseholdResource($household), 'Household deleted successfully.');

        } else {

            return $this->sendError('Validation Error.', ['Household delete Unsuccessful.']);
        }
    }


    private function storePUTData($request, $household){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $household->name = $request->input('name');
        $household->phone_number = $request->input('phone_number');
        $household->country = $request->input('country');

        if($request->has('code')){
            $household->code = $request->input('code');
        }else{
            $household->code = Str::random(10);
        }

        if ($household->save()) {
            return true;
        } else {
            return false;
        }

    }
}
