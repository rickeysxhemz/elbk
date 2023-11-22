<!-- Location Sign-In Page -->

@extends ('layout')

@section('title', 'Home')

@section('content')

    <section>
        <form action="/login" method="POST">
            <h1>Manager Login</h1>
            <select 
                id="locations" 
                name="location"
                required
            >
                @foreach ($locations as $loc)
                    <option key={{ $loc->id }} value="{{ $loc->location }}">{{ $loc->location }}</option>
                @endforeach
            </select>
            <select 
                id="phones" 
                name="phone"
                required
            >
                @foreach ($managers as $man)
                    <option key={{ $man->id }} value="{{ $man->phone }}">
                        {{ $man->name }} &mdash; {{ $man->phone }}
                    </option>
                @endforeach
            </select>
            <input 
                type="password"
                name="password"
                placeholder="Password"
                required
            />
            <button type="submit">Sign In</button>
        </form>
    </section>

@endsection