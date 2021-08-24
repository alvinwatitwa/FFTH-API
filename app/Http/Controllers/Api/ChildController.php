<?php

namespace App\Http\Controllers\Api;

use App\Child;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Child as ChildResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class ChildController extends BaseController
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->sendResponse(ChildResource::collection(Child::with('household')->get()), 'Data fetched successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
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
     * @return Response
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
     * @return Response
     */
    public function edit(Child $child)
    {
        //
    }

    /**
     * @param Request $request
     * @param Child $child
     * @return Response
     */
    public function update(Request $request, Child $child)
    {
        if ($this->storePUTData($request,$child)) {
            return $this->sendResponse(new ChildResource($child), 'Child Updated successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unable to save data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Child  $child
     * @return Response
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
     *Update all data
     */
    private function storePUTData($request, $child){
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
            Log::info($request->all());
            Log::info($validator->errors());
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $child->first_name = $request->input('first_name');
        $child->last_name = $request->input('last_name');
        $child->Country = $request->input('Country');
        $child->gender = $request->input('gender');
        $child->date_of_birth = $request->input('date_of_birth');
        $child->hobbies = $request->input('hobbies');
        $child->history = $request->input('history');
        $child->support_amount = $request->input('support_amount');
        $child->frequency = $request->input('frequency');
        $child->household_id = $request->input('household_id');

        // Check if a profile image has been uploaded
        if ($request->has('photo')) {
            // Get image file
            $image = $request->file('photo');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('first_name')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $child->photo = $filePath;
        }

        if ($child->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Response
     */
    public function getFirstFive()
    {
        return $this->sendResponse(ChildResource::collection(Child::with('household')->limit(5)->get()), 'Data fetched successfully');
    }
}
