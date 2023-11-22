<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\ClientCheckIn;
use App\Models\ManagerNumber;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $locations = User::all();  // get all locations
        $getLocation = app('session')->get('location');  // get current location

        if ($getLocation)  // if signed in, redirect to Check In page
            return redirect('/client/check-in');

        $managers = ManagerNumber::all();  // get all manager numbers

        return view('index', [
            'locations' => $locations,
            'managers' => $managers,
        ]);
    }


    public function clientCheckIn()
    {
        return view('client.check-in');
    }


    public function clientCheckInsList($phone)
    {
        // get client
        $client = Client::where('phone', $phone)->first();

        // get list of check-ins
        $checkIns = ClientCheckIn::where('client_id', $client->id)
                                 ->orderBy('created_at', 'DESC')
                                 ->take(5)
                                 ->get();

        return view('client.check-ins-list', [
            'name' => $client->first_name,
            'checkIns' => $checkIns,
            'bannerText' => app('session')->get('bannerText'),
        ]);
    }
}