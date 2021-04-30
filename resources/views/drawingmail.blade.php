@if($page=="drawing")
    @if($receiver=="approver")
        @switch($status)
            @case("Pending")
                <h1>Good day, {{$approver}}</h1>
                         <p>Please see below drawing details for your approval:<br><br>
                    <strong>Drawing No.: </strong>{{$ref_no}}<br>
                    <strong>Designer: </strong>{{$requestor}}<br><br><br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/app">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/app">Public Access</a>
                </i>
            @break
            @case("For Review")
                <h1>Good day, {{$approver}}</h1>
                         <p>Please see below drawing details for your approval:<br><br>
                    <strong>Drawing No: </strong>{{$ref_no}}<br>
                    <strong>Designer: </strong>{{$requestor}}<br><br><br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/app">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/app">Public Access</a>
                </i>
            @break
            @case("For Approval")
                <h1>Good day, {{$approver}}</h1>
                         <p>Please see below drawing details for your approval:<br><br>
                    <strong>Drawing No: </strong>{{$ref_no}}<br>
                    <strong>Designer: </strong>{{$requestor}}<br><br><br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/app">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/app">Public Access</a>
                </i>
            @break
        @endswitch
    @elseif($receiver=="filer")
        @switch($status)
            @case("Approved")
                <h1>Good day, {{$requestor}}</h1>
                         <p>Your drawing has been approved:<br><br>
                    <strong>Drawing No: </strong>{{$ref_no}}<br>
                    <strong>Approved By: </strong>{{$approver}}<br>
                    <strong>Remarks: </strong>{{$remarks}}<br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/drawings">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/drawings">Public Access</a>
                </i>
            @break
            @case("Rejected")
                <h1>Good day, {{$requestor}}</h1>
                         <p>Your drawing has been rejected:<br><br>
                    <strong>Drawing No: </strong>{{$ref_no}}<br>
                    <strong>Approved By: </strong>{{$approver}}<br>
                    <strong>Remarks: </strong>{{$remarks}}<br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/drawings">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/drawing/check/{{$ref_no}}/drawings">Public Access</a>
                </i>
            @break
        @endswitch
    @endif
@endif