@extends('layouts.app')

@section('title', __('Snowflake Distance Calculator'))
@section('description', __('Calculate the distance between two Discord Snowflakes.'))
@section('keywords', 'snowflakes, two snowflakes, distance, calculate', 'time', 'date')
@section('robots', 'index, follow')

@section('content')
    <div class="container">

        <h1 class="mb-4 mt-5 text-center text-white">{{ __('Snowflake Distance Calculator') }}</h1>
        <div class="mt-2 mb-4">
            <div class="row">

                <div class="col-12 col-xl-6 offset-xl-3">
                    <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                        <input id="snowflakeOneInput" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake 1') }}" value="{{ $snowflake1 }}" oninput="update();" onchange="update();" onkeyup="update();">
                    </div>
                </div>
                <div class="col-12 col-xl-6 offset-xl-3 mt-3">
                    <div class="input-group input-group-lg">
                    <span class="input-group-text bg-dark">
                        <i class="far fa-snowflake"></i>
                    </span>
                        <input id="snowflakeTwoInput" class="form-control form-control-lg" type="text" placeholder="{{ __('Snowflake 2') }}" value="{{ $snowflake2 }}" oninput="update();" onchange="update();" onkeyup="update();">
                    </div>
                </div>

                <div id="invalidInput" class="col-12 col-xl-6 offset-xl-3 mt-3" style="display: none;">
                    <div id="invalidInputMessage" class="alert alert-danger fade show" role="alert"></div>
                </div>

                <div id="infoCard" class="col-12 col-xl-6 offset-xl-3 mt-3" style="display: none;">
                    <div class="card text-white bg-dark">
                        <div class="card-body text-center">
                            <h2 class="fw-bold">{{ __('Distance between the two Snowflakes:') }}</h2>
                            <h3 class="fw-bold text-primary" id="snowflakeDistance"></h3>
                        </div>
                    </div>
                    <hr>
                    <div class="card text-white bg-dark">
                        <div class="card-body text-center">
                            <h5>Snowflake 1</h5>
                            <b>{{ __('Date') }}:</b> <span id="snowflakeOneDate"></span><br>
                            <b>{{ __('Relative') }}:</b> <span id="snowflakeOneRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <span id="snowflakeOneUnix"></span><br>
                        </div>
                    </div>
                    <div class="card text-white bg-dark mt-3">
                        <div class="card-body text-center">
                            <h5>Snowflake 2</h5>
                            <b>{{ __('Date') }}:</b> <span id="snowflakeTwoDate"></span><br>
                            <b>{{ __('Relative') }}:</b> <span id="snowflakeTwoRelative"></span><br>
                            <b>{{ __('Unix Timestamp') }}:</b> <span id="snowflakeTwoUnix"></span><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @push('scripts')
            <script>
                window.onload = function() {
                    update();
                };

                function update() {
                    var snowflakeOneInput = document.getElementById('snowflakeOneInput');
                    var snowflakeOneInputValue = snowflakeOneInput.value;
                    var snowflakeTwoInput = document.getElementById('snowflakeTwoInput');
                    var snowflakeTwoInputValue = snowflakeTwoInput.value;
                    var invalidInput = document.getElementById('invalidInput');
                    var infoCard = document.getElementById('infoCard');

                    infoCard.style.display = 'none';
                    invalidInput.style.display = 'none';

                    if(snowflakeOneInputValue.length > 0 && snowflakeTwoInputValue.length > 0) {
                        var snowflakeOneDate = validateSnowflake(snowflakeOneInputValue);
                        var snowflakeTwoDate = validateSnowflake(snowflakeTwoInputValue);

                        if (snowflakeOneDate.toString().startsWith("That")) {
                            document.getElementById('invalidInputMessage').innerHTML = "<b>Snowflake 1:</b>" + snowflakeOneDate;
                            invalidInput.style.display = '';
                        } else if (snowflakeTwoDate.toString().startsWith("That")) {
                            document.getElementById('invalidInputMessage').innerHTML = "<b>Snowflake 2:</b>" + snowflakeTwoDate;
                            invalidInput.style.display = '';
                        } else {
                            var moment1 = moment(snowflakeOneDate);
                            var moment2 = moment(snowflakeTwoDate);
                            var difference = moment.duration(moment1.diff(moment2));
                            if(snowflakeTwoDate.getTime() > snowflakeOneDate.getTime()) {
                                difference = moment.duration(moment2.diff(moment1));
                            }
                            document.getElementById('snowflakeDistance').innerHTML =
                                difference.years() + " <small>year(s)</small><br>" +
                                difference.months() + " <small>month(s)</small><br>" +
                                difference.days() + " <small>day(s)</small><br>" +
                                difference.hours() + " <small>hour(s)</small><br>" +
                                difference.minutes() + " <small>minute(s)</small><br>" +
                                difference.seconds() + " <small>second(s)</small><br>" +
                                difference.milliseconds() + " <small>millisecond(s)</small>"
                            ;

                            document.getElementById('snowflakeOneDate').innerText = snowflakeOneDate;
                            document.getElementById('snowflakeOneRelative').innerText = moment.utc(snowflakeOneDate).local().fromNow();
                            document.getElementById('snowflakeOneUnix').innerText = snowflakeOneDate.getTime();

                            document.getElementById('snowflakeTwoDate').innerText = snowflakeTwoDate;
                            document.getElementById('snowflakeTwoRelative').innerText = moment.utc(snowflakeTwoDate).local().fromNow();
                            document.getElementById('snowflakeTwoUnix').innerText = snowflakeTwoDate.getTime();
                            infoCard.style.display = '';
                        }
                    }
                }
            </script>
        @endpush

    </div>
@endsection
