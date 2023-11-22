<!-- Client Registration Page -->

@extends ('layout')

@section('title', 'Registration')

@section('content')

    <section>
        <form action="/client/store" method="POST">
            <h1>Client Registration</h1>
            <input 
                type="text"
                name="first_name"
                placeholder="First Name"
                required
            />
            <input 
                type="text"
                name="last_name"
                placeholder="Last Name"
                required
            />
            <input 
                type="text"
                name="phone"
                value="{{ $phone }}"
                required
            />
            <button type="submit">Register</button>
        </form>
    </section>

@endsection