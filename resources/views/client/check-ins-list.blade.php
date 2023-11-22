<!-- Client Check-Ins List Page -->

@extends ('layout')

@section('title', "$name's Check Ins")

@section('content')

    <div id="banner">
        <p>{!! $bannerText ?? '' !!}</p>
    </div>

    <section id="check-ins">
        <h1>{{ $name }}'s<br>Latest Check Ins</h1>
        <ul>
            @foreach ($checkIns as $ci)
                <li>{{ date_format($ci->created_at, 'l, F j, o') }}</li>
            @endforeach
        </ul>
    </section>

    <a id="flashing" class="hidden" href="/">Return</a>

@endsection

@section('scripts')
<script>
    // show hidden Return button after 2 seconds
    setTimeout(function () {
        var flash = document.getElementById('flashing')
        flash.classList.remove('hidden')
    }, 2000);

    // remove banner after 2 seconds
    setTimeout(function () {
        var flash = document.getElementById('banner')
        flash.classList.add('hidden')
    }, 2000);

    // redirect to home page after 30 seconds
    setTimeout(function () {
        window.location.href = "/";
    }, 1000 * 30);
</script>
@endsection