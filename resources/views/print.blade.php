<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <title>{{ env('APP_NAME') }} / print-exercises</title>
</head>

<body>
    <h1>Exercicios de matemática {{  env('APP_NAME') }}</h1>
    <br>
    <hr>
    <br>

    @foreach ($exercises as $exercise)
        <div class="d-flex justify-content-left">
            <small class="my-auto mr-3">({{ $exercise['exercise_number']}})
                &nbsp; {{ " _ " }} &nbsp;
            </small>
            <h5>
                {{ $exercise['exercise'] }}
            </h5>
        </div>
    @endforeach
    <br>
    <hr>
    <br>
    <h3>Solutions</h3>
    <br>
    <small>
        @foreach ($exercises as $exercise)
            <div class="d-flex justify-content-left">
                <div class="my-auto mr-3">({{ $exercise['exercise_number'] }})
                    &nbsp; {{ " _ " }} &nbsp;
                </div>
                {{ $exercise['exercise'] }}
                {{ $exercise['result'] }}

            </div>
        @endforeach
    </small>
</body>

</html>