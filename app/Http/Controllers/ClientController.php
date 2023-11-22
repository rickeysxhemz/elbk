<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientCheckIn;
use Illuminate\Http\Request;

use Twilio\Rest\Client as Twilio;

class ClientController extends Controller
{
    public function storeCheckIn($id)
    {
        $ci = new ClientCheckIn;
        $ci->client_id = $id;
        $ci->location_id = app('session')->get('location_id');
        $ci->save();
    }

    /**
     * Check if resource exists.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkExists(Request $request)
    {
        // check if client exists
        if (Client::where('phone', $request->phone)->first()) {
            // get client
            $client = Client::where('phone', $request->phone)->first();

            // get banner
            $newest = ClientCheckIn::where('client_id', $client->id)->orderBy('created_at', 'DESC')->first(); // get latest check-in time
            // set past
            $past = $newest->created_at->format("Y-m-d");
            // set now
            $now = date_create(date('Y-m-d H:i:s', time()), timezone_open('America/Los_Angeles')); // keep to not mess with below messages
            $now2 = date("Y-m-d", time());
            // convert to timestamps
            $past_ts = strtotime($past);
            $now_ts = strtotime($now2);
            // get day
            $diff = $now_ts - $past_ts;
            $day = ceil($diff / 86400);
            app('session')->put('bannerText', "Welcome back!  It has been <strong>$day days</strong> since your last appointment.");

            // store check in
            $this::storeCheckIn($client->id);

            // send SMS message
            $twilio = new Twilio(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            // send to management
            $body_management = strtoupper("$client->first_name $client->last_name") .
                " just checked in at " . strtoupper(app('session')->get('location')) .
                " at " . $now->format('h:iA') . " on " . $now->format('l, F j, o') .
                ".  It has been $day DAYS since their last appointment."; // format management text message
            // send to MASTER
            $twilio->messages->create(
                env('MASTER_NUMBER'),
                array(
                    'from' => env('TWILIO_NUMBER'),
                    'body' => $body_management,
                )
            );
            // send to manager
            $twilio->messages->create(
                app('session')->get('phone'),
                array(
                    'from' => env('TWILIO_NUMBER'),
                    'body' => $body_management,
                )
            );
            // send to client
            $body_client = "Welcome back!  You just checked in at Elegant Lashes by Katie's " .
                strtoupper(app('session')->get('location')) . " location " .
                "at " . $now->format('h:iA') . " on " . $now->format('l, F j, o') .
                ".  It has been $day DAYS since your last appointment."; // format client text message
            $twilio->messages->create(
                $client->phone,
                array(
                    'from' => env('TWILIO_NUMBER'),
                    'body' => $body_client,
                )
            );

            // redirect to Check-Ins List page
            return redirect("/client/list/$request->phone");
        }
        // if client doesn't exist, redirect to registration page
        return redirect("/client/register/$request->phone");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($phone)
    {
        return view('client.registration', [
            'phone' => $phone,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check that client does not exist
        if (!Client::where('phone', $request->phone)->first()) {
            // insert client info into database
            $client = new Client;
            $client->phone = $request->phone;
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->save();

            // store check in
            $this::storeCheckIn($client->id);

            // send SMS message
            $twilio = new Twilio(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            // send to management
            $now = date_create(date('Y-m-d H:i:s', time()), timezone_open('America/Los_Angeles')); // get current timestamp
            $body_management = strtoupper("$client->first_name $client->last_name") .
                " just registered at " . strtoupper(app('session')->get('location')) .
                " at " . $now->format('h:iA') . " on " . $now->format('l, F j, o') . "."; // format text message
            $twilio->messages->create(
                env('MASTER_NUMBER'),
                // send to MASTER
                array(
                    'from' => env('TWILIO_NUMBER'),
                    'body' => $body_management,
                )
            );
            $twilio->messages->create(
                app('session')->get('phone'),
                // send to manager
                array(
                    'from' => env('TWILIO_NUMBER'),
                    'body' => $body_management,
                )
            );
            // send to client
            $body_client = "You just registered at Elegant Lashes by Katie's " .
                strtoupper(app('session')->get('location')) . " location " .
                "at " . $now->format('h:iA') . " on " . $now->format('l, F j, o') .
                ".  Welcome!"; // format text message
            $twilio->messages->create(
                $client->phone,
                array(
                    'from' => env('TWILIO_NUMBER'),
                    'body' => $body_client,
                )
            );

            // redirect to Check-Ins List page
            app('session')->put('bannerText', "Welcome to Elegant Lashes by Katie!");
            return redirect("/client/list/$request->phone");
        }
        return redirect('/client/check-in');
    }
}