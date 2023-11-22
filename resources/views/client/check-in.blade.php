<!-- Client Check-In Page -->

@extends ('layout')

@section('title', 'Check-In')

@section('content')

    <section>
        <form action="/client/check" method="POST">
            <p style="font-size:20px; text-align:center">Please enter your number to check in.</p>
            <br>
            <input 
                type="text"
                name="phone"
                placeholder="Phone # (1234567890)"
                required
            />
            <button type="submit">Check In</button>
        </form>
    </section>

@endsection