<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>



        @if($details['type'] === 'Registration Info')

        <p>{{ $details['hello']}}</p><br>
        <p>{{ $details['text1']}}</p><br>
        <p>{{ $details['text2']}}</p><br>

        <p>{{ $details['text3']}}</p>
        <p>{{ $details['text4']}}</p><br>

        <p>{{ $details['text5']}}</p><br>
        <p>{{ $details['text6']}}</p><br>
        <p>{{ $details['text7']}}</p><br>

        @elseif($details['type'] === 'sent to confirm')
        <p>{{ $details['hello']}}</p><br>
        <p>{{ $details['text1']}}</p><br>
        <p>{{ $details['text2']}}</p>
        <a href="{{ route('resetconfirm', ['action' => $details['token']]) }}">
            {{ route('resetconfirm', ['action' => $details['token']]) }}
        </a>
        <br><br>
        <p>Thank you.</p>
        <p>Tradeforyou</p>
        @else
        <p>{{ $details['hello']}}</p><br>

        <p>{{ $details['text1']}}</p>
        <p>{{ $details['text2']}}</p><br>

        <p>{{ $details['text3']}}</p><br>

        <p>{{ $details['text4']}}</p>
        <p>{{ $details['text5']}}</p><br>

        <p>{{ $details['text6']}}</p>



        @endif

        <br>
        <br>
        <br>
        <br>
        <br>
    </div>

</html>
