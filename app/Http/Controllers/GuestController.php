<?php

namespace App\Http\Controllers;

use App\Accommodation;
use App\Exports\GuestExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Guest;
use App\Fellow;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use PragmaRX\Countries\Package\Countries;

class GuestController extends Controller
{
    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.route')->only('show');
        $this->countries = new Countries();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {

        // Check, if any role is set
        $userRole = auth()->user()->role->name;

        if (!($userRole === 'Guest' OR $userRole === 'Admin')) {

            return view('pages.index')
                ->with('error', 'You have no valid role set, ask your Administrator, how to set a valid role!');
        }

        // First get the model with all necessary dependencies
        $guests = Guest::with('fellows', 'user')->orderBy('arrival_date', 'desc');

        // If you are guest, we want to restrict, what you can see
        if ($userRole === 'Guest') {
            $guests = $guests->where('user_id', auth()->user()->id);
        }

        // Full text search for fields mentioned in Model Guest
        if ($request->filled('search')) {
            $guests = $guests->search($request->get('search'));
            $request->flash();
        }

        // Date range search for
        if ($request->filled(['search_from_date', 'search_to_date'])){
            $guests = $guests->whereBetween('arrival_date', [$request['search_from_date'], $request['search_to_date']]);
            $request->flash();
        }

        // Finally get, what you came for ->
        $guests = $guests->get();
        $guests = $this->consolidateViewArray($guests);

        return view('guests/index')
            ->with('guests', $guests)
            ;
    }

    protected function paginate($items, $perPage = 6, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    protected function consolidateViewArray($guests){
        $bookings = [];

        // Do a prefilter on the arrival_date of the Guests so you can group them
        foreach ($guests as $index => $guest){
            $guestArrivalDate = (new Carbon($guest['arrival_date']))->format('d.m.Y');
            $guestAccommodationId = $guest['accommodation_id'];
            $groupKey = $guestArrivalDate.'_'.$guestAccommodationId;
            $bookings[$groupKey][] = $guest;
        }

        $guestsFinal = [];
        $index = 0;
        // Put together the final array
        foreach ($bookings as $guestGroup){

            // Array initialisation
            $maxDepartureDate = null;
            $minCreatedAt = new Carbon();
            $guestGroupCount = 0;
            $fellows = [];

            foreach ($guestGroup as $groupKey => $guest) {
                if ($maxDepartureDate < ($guest['act_departure_date'])){
                    $maxDepartureDate = ($guest['act_departure_date']);
                } // Check with every run, if you can overwrite your old $maxDepartureDate

                if ($minCreatedAt > ($guest['created_at'])){
                    $minCreatedAt = ($guest['created_at']);
                }

                if ($guest->fellows) {
                    $guestGroupCount += 1 + count($guest->fellows);
                    foreach ($guest->fellows as $fellow) {
                        $fellows [] = $fellow;
                    }
                } else {
                    $guestGroupCount += 1;
                }

                // Add flag icons to guests
                $guest->flag = $this->countries->where('name.common', $guest->citizenship)->first()->flag->flag_icon;
            }

            if (isset($maxDepartureDate)) {
                $maxDepartureDate = (new Carbon($maxDepartureDate))->format('d.m.Y');
            } else {
                $maxDepartureDate = 'Not checked out!';
            }

            $guestsFinal[$index]['start'] = (new Carbon($guestGroup[0]->arrival_date));
            $guestsFinal[$index]['end'] = $maxDepartureDate;
            $guestsFinal[$index]['count'] = $guestGroupCount;
            $guestsFinal[$index]['created_by'] = $guestGroup[0]->user->name;
            $guestsFinal[$index]['created_at'] = (new Carbon())->diffInDays($minCreatedAt);
            $guestsFinal[$index]['accommodation'] = $guestGroup[0]->accommodation->name;
            $guestsFinal[$index]['fellows'] = $fellows;
            $guestsFinal[$index]['guests'] = $guestGroup;

//            dd($guestsFinal);
            $index++;
        }

        return $this->paginate($guestsFinal, 6, null, ['path'=>url('guests')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $countries = $this->countries->all()->pluck('name.common')->toArray();

        $accommodations = Accommodation::all();
        return view('guests/create')
            ->with('accommodations', $accommodations)
            ->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $baseValidation = [
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'citizenship' => 'required',
            'document_type' => 'required',
            'document' => 'required',
            'address' => 'required',
            'arrival_date' => 'required',
            'est_departure_date' => 'required',
            'signature' => 'required',
            #'accommodation_id' => 'required',
        ];

        $fellows = request()->get('fellows');
        if ($fellows){
            $baseValidation['*.*.first_name'] = 'required|min:2';
            $baseValidation['*.*.last_name'] = 'required|min:2';
            $baseValidation['*.*.birth_date'] = 'required|date';
        }

        $this->validate($request, $baseValidation);

        // Check if accommodation_id is empty, if so, take from user (because then it is a guest with just
        // one accommodation_id possible -> set in Dashboard pane
        if (auth()->user()->role->name === 'Guest'){
            $request['accommodation_id'] = auth()->user()->accommodation->id;
        }

        // Process guest data and get user_id
        $guest = new Guest;
        $formData = $request->all();
        $formData['user_id'] = auth()->user()->id;
        $guest->fill($formData);
        $guest->save();

        // Check if fellows is not empty and process fellows data
        if ($fellows){
            // Get the last inserted guest_id for inserting in fellows table
            $insertedId = $guest->id;

            foreach ($fellows as $formFellow) {
                $formFellow['guest_id'] = $insertedId;
                $fellow = new Fellow;
                $fellow->fill($formFellow);
                $fellow->save();
            }
        }

        if ($request->has('save_back')){
            return redirect('guests/create')->with('success', 'Guest created');
        }

        return redirect('guests/')->with('success', 'Guest created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->flag = $this->countries->where('name.common', $guest->citizenship)->first()->flag->flag_icon;

        return view('guests/show')
            ->with('guest', $guest)
            ->with('fellows', $guest->fellows);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $guest = Guest::find($id);
        return view('guests/edit')
            ->with('guest', $guest)
            ->with('fellows', $guest->fellows);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Guest $guest
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Guest $guest)
    {
        $baseValidation = [
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'citizenship' => 'required',
            'document_type' => 'required',
            'document' => 'required',
            'address' => 'required',
            'arrival_date' => 'required',
            'est_departure_date' => 'required',
            'signature' => 'required',
        ];

        $fellows = request()->get('fellows');

        if ($fellows){
            $baseValidation['*.*.first_name'] = 'required|min:2';
            $baseValidation['*.*.last_name'] = 'required|min:2';
            $baseValidation['*.*.birth_date'] = 'required|date';
        }

        $this->validate($request, $baseValidation);

        // Process guest data
        $formData = $request->all();
        $guest->fill($formData);
        $guest->save();

        // Check if fellows is not empty and process fellows data
        // Get the fellows id from database and store it in an array as well as prepare a list of to be edited fellows
        $existingFellows = Fellow::select('id')->where('guest_id', '=', $guest->id)->get()->toArray();
        $existingFellows = array_map(function ($a) { return $a['id'];}, $existingFellows);
        $fellowIdList = [];

        // Check the incoming fellow array for new or edited fellows
        if ($fellows) {
            foreach ($fellows as $key => $formFellow) {
                if (strlen($key >= 5)) {
                    // If you just edit the Fellow you have to figure out the id where to save the data
                    $fellowId = substr($key, 3);
                    $fellowIdList[] = $fellowId;
                    $fellow = Fellow::find($fellowId);
                    $fellow->fill($formFellow);
                    $fellow->save();
                } else {
                    // Otherwise just create the fellow anew
                    $formFellow['guest_id'] = $guest->id;
                    $fellow = new Fellow;
                    $fellow->fill($formFellow);
                    $fellow->save();
                }
            }
        }

        // Check, if fellows have to be deleted in database because they are not present in array fellows
        foreach ($existingFellows as $dbFellow){
            if(!in_array($dbFellow, $fellowIdList)) {
                $fellow = Fellow::find($dbFellow);
                $fellow->delete();
            }
        }
        return back()->with('success', 'Record updated');
        #return redirect()->route('guests.show',$id)->with('success', 'Record updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guest $guest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Guest $guest)
    {
        $guest->fellows()->delete();
        $guest->delete();
        return redirect('guests/')->with('success', 'Record deleted');
    }

    /**
     * Export all the guests.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $filename = (new Carbon())->format('Ymd_His').'_guests.xlsx';

        return Excel::download(new GuestExport(), $filename);
    }

}
