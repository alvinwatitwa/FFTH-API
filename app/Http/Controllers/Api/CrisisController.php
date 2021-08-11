<?php

namespace App\Http\Controllers\Api;

use App\Crisis;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Crisis as CrisisResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CrisisController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(CrisisResource::collection(Crisis::paginate(10)), 'Data fetched successfully');
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

        $crisis = new Crisis();

        return $this->storePUTData($request,$crisis);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Crisis  $crisis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            $crisis = Crisis::findOrfail($id);

            return $this->sendResponse(new CrisisResource($crisis), 'Data fetched successfully');

        } catch (ModelNotFoundException  $e) {

            return $this->sendError('NotFoundException', ['We did not find that id!']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Crisis  $crisis
     * @return \Illuminate\Http\Response
     */
    public function edit(Crisis $crisis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Crisis  $crisis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crisis $crisis)
    {

        return $this->storePUTData($request,$crisis);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Crisis  $crisis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crisis $crisis)
    {

        if ($crisis->delete()) {

            return $this->sendResponse(new CrisisResource($crisis), 'Crisis fund deleted successfully.');

        } else {

            return $this->sendError('Validation Error.', ['Crisis fund delete Unsuccessful.']);
        }

    }

    /**
     *
     */
    private function storePUTData($request, $crisis){

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'frequency' => 'required',
            'sponsor_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $crisis->amount =  $request->input('amount');
        $crisis->frequency =  $request->input('frequency');
        $crisis->sponsor_id =  $request->input('sponsor_id');

        if ($crisis->save()) {
            return $this->sendResponse(new CrisisResource($crisis), 'Crisis register successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unnable to save data']);
        }

    }

}
