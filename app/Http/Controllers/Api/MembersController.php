<?php


namespace App\Http\Controllers\Api;


use App\Child;
use App\HouseholdMember;
use App\Http\Resources\Child as ChildResource;
use App\Http\Resources\HouseholdMember as HouseholdMemberResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MembersController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {

      $members =  HouseholdMember::where('household_id', $id)->get();

        return response()->json([
            'data' => $members,
            'message' => 'Data Fetched Successfully'
            ]);
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

        $member = new HouseholdMember();

        if ($this->storePUTData($request, $member)) {
            return $this->sendResponse(new HouseholdMemberResource($member), 'Member Added successfully.');
        } else {
            return $this->sendError('Database Error.', ['Unable to save data']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $member = HouseholdMember::findOrfail($id);

            return $this->sendResponse(new HouseholdMemberResource($member), 'Data fetched successfully');

        } catch (ModelNotFoundException  $e) {

            return $this->sendError('NotFoundException', ['We did not find that id!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HouseholdMember $member
     * @return \Illuminate\Http\Response
     */
    public function edit(HouseholdMember $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param HouseholdMember $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HouseholdMember $member)
    {
        if ($this->storePUTData($request,$member)) {
            return $this->sendResponse(new HouseholdMemberResource($member), 'Member Updated successfully.');
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
    public function destroy(HouseholdMember $member)
    {
        //

        if ($member->delete()) {

            return $this->sendResponse(new HouseholdMemberResource($member), 'Member deleted successfully.');

        } else {

            return $this->sendError('Validation Error.', ['Member delete Unsuccessful.']);
        }
    }

    /**
     *Update all data
     */
    private function storePUTData($request, $member){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'household_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $member->first_name = $request->input('first_name');
        $member->last_name = $request->input('last_name');
        $member->gender = $request->input('gender');
        $member->phone = $request->input('phone');
        $member->household_id = $request->input('household_id');
        $member->household_head = $request->input('household_head') == "true";

        if ($member->save()) {
            return true;
        } else {
            return false;
        }
    }

}
