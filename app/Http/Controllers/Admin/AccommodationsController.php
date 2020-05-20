<?php

namespace App\Http\Controllers\Admin;

use App\Accommodation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccommodationsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin/accommodations/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $accommodation = new Accommodation();
        $formData = $request->all();
        $accommodation->fill($formData);
        $accommodation->save();
        return redirect()->route('admin.dashboard')->with('success', 'Accommodation created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accommodation  $accommodation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Accommodation $accommodation)
    {
        // Figure out if accommodation is set and act accordingly
        // Change the user_name
        if (isset($request['name'])) {
            $name = $request['name'];
            $accommodation->name = $name;
            $accommodation->save();
            return back()->with('success', 'Accommodation name changed');
        }

        // Change the capacity of accommodation
        if (isset($request['capacity'])) {
            $capacity = $request['capacity'];

            $accommodation->capacity = $capacity;
            $accommodation->save();
            return back()->with('success', 'Accommodation capacity changed');
        }
        return back()->with('error', 'Something went wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Accommodation $accommodation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Accommodation $accommodation)
    {
        $connectedGuests = $accommodation->guests()->get('id')->toArray();
        $connectedGuests = array_column($connectedGuests, 'id');

        if ($accommodation->guests()->count() !== 0){
            return back()->with('error', 'Accommodation still used for guest_id(s) '.implode(", ",$connectedGuests));
        }

        $accommodation->delete();
        return back()->with('success', 'Accommodation deleted');
    }

}
