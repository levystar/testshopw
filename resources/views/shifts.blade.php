<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}"/>
    <style>
        .header{
            font-size: 1.23em;
            font-weight: 700;
        }
        .footer{
            font-size: 1.23em;
            font-weight: 700;
            background: #bebeff;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="text-center header">
                    <td>Staff ID</td>
                    @foreach ($totalShifts as $day)
                        <td>Day {{$day->getDay()}}</td>
                    @endforeach
                    </thead>
                    <tbody class="text-center">
                    @foreach ($staffIds as $staffId)
                        <tr>
                            <td>{{ $staffId }}</td>

                            @foreach ($totalShifts as $day)
                                <td>
                                    @if($shift = $day->getShiftForEmployee($staffId))
                                        {{ $shift->getStartTime() }} - {{ $shift->getEndTime() }}
                                    @else
                                        {{ 'n/a' }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="table-info footer">
                        <td>Total Hours</td>
                        @foreach ($totalShifts as $day)
                            <td>{{$day->getTotalHours()}}</td>
                        @endforeach
                    </tr>
                    <tr class="table-info footer">
                        <td>Minutes worked alone</td>
                        @foreach ($totalShifts as $day)
                            <td>{{$day->getMinutesWorkedAlone()}}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

</div>
</div>
</body>
</html>
