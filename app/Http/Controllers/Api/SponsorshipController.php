<?php

namespace App\Http\Controllers\Api;

use App\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Sponsorship as SponsorshipResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SponsorshipController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(SponsorshipResource::collection(Sponsorship::paginate(10)), 'Data fetched successfully');
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

        $sponsorship = new Sponsorship();

        return $this->storePUTData($request,$sponsorship);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            $sponsorship = Sponsorship::findOrfail($id);

            return $this->sendResponse(new SponsorshipResource($sponsorship), 'Data fetched successfully');

        } catch (ModelNotFoundException  $e) {

            return $this->sendError('NotFoundException', ['We did not find that id!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsorship $sponsorship)
    {
        //
        return $this->storePUTData($request,$sponsorship);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsorship $sponsorship)
    {

        if ($sponsorship->delete()) {

            return $this->sendResponse(new SponsorshipResource($sponsorship), 'Sponsorship deleted successfully.');

        } else {

            return $this->sendError('Validation Error.', ['Sponsorship delete Unsuccessful.']);
        }

    }

    /**
     *
     */
    private function storePUTData($request, $sponsorship){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' =>  ['required', 'email'],
            'phone' =>  'required',
            'country' =>  'required',
            'street' =>  'required',
            'city' =>  'required',
            'state_province' =>  'required',
            'zip_code' =>  'required',
            'child_id' =>  'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $sponsorship->first_name =  $request->input('first_name');
        $sponsorship->last_name =  $request->input('last_name');
        $sponsorship->email =  $request->input('email');
        $sponsorship->phone =  $request->input('phone');
        $sponsorship->country =  $request->input('country');
        $sponsorship->street =  $request->input('street');
        $sponsorship->city =  $request->input('city');
        $sponsorship->state_province =  $request->input('state_province');
        $sponsorship->zip_code =  $request->input('zip_code');
        $sponsorship->child_id =  $request->input('child_id');

        if ($sponsorship->save()) {
            return $this->sendResponse(new SponsorshipResource($sponsorship), 'Sponsorship register successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unnable to save data']);
        }

    }
}
