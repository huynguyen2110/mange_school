<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        body {
            /*font-family: ipag;*/
            margin: 0px;
        }

        table, td{
            border: 1px solid black;
            border-collapse: collapse;
            white-space: pre-wrap;
            word-wrap: break-word;
            width:100%;
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th >Tên</th>
            <th >Email</th>
            <th >Ngành</th>
            <th >Khóa</th>
        </tr>
        @foreach ($data as $index => $item)
            <tr>
                <td >{{$item->name}}</td>
                <td >{{$item->email}}</td>
                @if($item->majors)
                    <td >{{$item->majors->name}}</td>
                @else
                    <td></td>
                @endif
                @if($item->courses)
                    <td >{{$item->courses->name}}</td>
                @else
                    <td></td>
                @endif
            </tr>
            @endforeach

    </table>

</body>
</html>
