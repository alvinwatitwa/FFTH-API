<?php

namespace App\Http\Controllers\Api;

use App\Child;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Child as ChildResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChildController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(ChildResource::collection(Child::all()), 'Data fetched successfully');
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

        $child = new Child();

        if ($this->storePUTData($request,$child)) {
            return $this->sendResponse(new ChildResource($child), 'Child Added successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unnable to save data']);
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

            $child = Child::findOrfail($id);

            return $this->sendResponse(new ChildResource($child), 'Data fetched successfully');

        } catch (ModelNotFoundException  $e) {

            return $this->sendError('NotFoundException', ['We did not find that id!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function edit(Child $child)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Child $child)
    {
        //

        if ($this->storePUTData($request,$child)) {
            return $this->sendResponse(new ChildResource($child), 'Child Updated successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unnable to save data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function destroy(Child $child)
    {
        //

        if ($child->delete()) {

            return $this->sendResponse(new ChildResource($child), 'Child deleted successfully.');

        } else {

            return $this->sendError('Validation Error.', ['Child delete Unsuccessful.']);
        }
    }

    /**
     *
     */
    private function storePUTData($request, $child){

        $child_image_name = "";

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'Country' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            // 'photo' => 'required|mimes:jpg,jpeg,png,gif',
            'hobbies' => 'required',
            'history' => 'required',
            'support_amount' => 'required',
            'frequency' => 'required',
            'household_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if($request->input('photo') !== null || !empty($request->input('photo'))){

            if($request->hasfile('photo')){
               $file = $request->file('photo');
               $child_image_name = time().$file->getClientOriginalName();
               $file->move(storage_path().'/app/public/images/', $child_image_name);
            }

        }else{
            $child_image_name = null;
        }

        $child->first_name = $request->input('first_name');
        $child->last_name = $request->input('last_name');
        $child->Country = $request->input('Country');
        $child->gender = $request->input('gender');
        $child->date_of_birth = $request->input('date_of_birth');
        $child->photo = $request->input('photo');
        $child->hobbies = $request->input('hobbies');
        $child->history = $request->input('history');
        $child->support_amount = $request->input('support_amount');
        $child->frequency = $request->input('frequency');

        if($child_image_name !== null){

            $child->photo = 'images/' . $child_image_name;

        }

        if ($child->save()) {
            return true;
        } else {
            return false;
        }

    }
}
