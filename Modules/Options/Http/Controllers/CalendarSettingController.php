<?php

namespace Modules\Options\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Options\Entities\CalendarSetting;

class CalendarSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $userId = auth()->id();
        $calendarSetting = CalendarSetting::where("user_id", $userId)->first();
        return view('options::calendar.index', [
            'calendarSetting' => $calendarSetting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        echo $id;
        // $calendarSetting = CalendarSetting::findorfail($id);
        // if (!$calendarSetting)
        //     $calendarSetting = new CalendarSetting;
        // return view('options::calendar.index', [
        //     'calendarSetting' => $calendarSetting
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit()
    {
        $calendarSetting = CalendarSetting::first();

        return view('options::options.index', [
            'calendarSetting' => $calendarSetting
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $requestData = $request->except('_token', '_method');
        $userId = auth()->id();
        $requestData['user_id'] = $userId;
        $prevData = CalendarSetting::where("user_id", $userId)->first();
        if (!$prevData) CalendarSetting::create($requestData);
        else $prevData->update($requestData);
        return view('options::calendar.index', [
            'calendarSetting' => $requestData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
