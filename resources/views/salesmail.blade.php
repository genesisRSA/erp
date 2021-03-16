@if($page=="forecast")
    @if($receiver=="approver")
        @switch($status)
            @case("Pending")
                <h1>Good day, {{$approver}}</h1>
                         <p>Please see below sales forecast details for your approval:<br><br>
                    <strong>Ref. No: </strong>{{$ref_no}}<br>
                    <strong>Filed By: </strong>{{$requestor}}<br><br><br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/approval">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/approval">Public Access</a>
                </i>
            @break
            @case("For Review")
                <h1>Good day, {{$approver}}</h1>
                         <p>Please see below sales forecast details for your approval:<br><br>
                    <strong>Ref. No: </strong>{{$ref_no}}<br>
                    <strong>Filed By: </strong>{{$requestor}}<br><br><br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/approval">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/approval">Public Access</a>
                </i>
            @break
            @case("For Approval")
                <h1>Good day, {{$approver}}</h1>
                         <p>Please see below sales forecast details for your approval:<br><br>
                    <strong>Ref. No: </strong>{{$ref_no}}<br>
                    <strong>Filed By: </strong>{{$requestor}}<br><br><br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/approval">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/approval">Public Access</a>
                </i>
            @break
        @endswitch
    @elseif($receiver=="filer")
        @switch($status)
            @case("Approved")
                <h1>Good day, {{$requestor}}</h1>
                         <p>Your sales forecast has been approved:<br><br>
                    <strong>Ref. No: </strong>{{$ref_no}}<br>
                    <strong>Approved By: </strong>{{$approver}}<br>
                    <strong>Remarks: </strong>{{$remarks}}<br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/view">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/view">Public Access</a>
                </i>
            @break
            @case("Rejected")
                <h1>Good day, {{$requestor}}</h1>
                         <p>Your sales forecast has been rejected:<br><br>
                    <strong>Ref. No: </strong>{{$ref_no}}<br>
                    <strong>Approved By: </strong>{{$approver}}<br>
                    <strong>Remarks: </strong>{{$remarks}}<br>
                </p>
                <i>For more details you can click below: <br>
                    <a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/view">Office Access</a>
                <br><a href="http://127.0.0.1:8000/reiss/forecast/check/{{$ref_no}}/view">Public Access</a>
                </i>
            @break
        @endswitch
    @endif
@elseif($page=="quotation")
    @if($receiver=="approver")
    @switch($status)
        @case("Pending")
            <h1>Good day, {{$approver}}</h1>
                    <p>Please see below sales quotation details for your approval:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Filed By: </strong>{{$requestor}}<br><br><br>
            </p>
            <i>For more details you can click below: <br>
                <a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/approval">Office Access</a>
            <br><a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/approval">Public Access</a>
            </i>
        @break
        @case("For Review")
            <h1>Good day, {{$approver}}</h1>
                    <p>Please see below sales quotation details for your approval:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Filed By: </strong>{{$requestor}}<br><br><br>
            </p>
            <i>For more details you can click below: <br>
                <a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/approval">Office Access</a>
            <br><a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/approval">Public Access</a>
            </i>
        @break
        @case("For Approval")
            <h1>Good day, {{$approver}}</h1>
                    <p>Please see below sales quotation details for your approval:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Filed By: </strong>{{$requestor}}<br><br><br>
            </p>
            <i>For more details you can click below: <br>
                <a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/approval">Office Access</a>
            <br><a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/approval">Public Access</a>
            </i>
        @break
    @endswitch
    @elseif($receiver=="filer")
    @switch($status)
        @case("Approved")
            <h1>Good day, {{$requestor}}</h1>
                    <p>Your sales quotation has been approved:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Approved By: </strong>{{$approver}}<br>
                <strong>Remarks: </strong>{{$remarks}}<br>
            </p>
            <i>For more details you can click below: <br>
                <a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/view">Office Access</a>
            <br><a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/view">Public Access</a>
            </i>
        @break
        @case("Rejected")
            <h1>Good day, {{$requestor}}</h1>
                    <p>Your sales quotation has been rejected:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Approved By: </strong>{{$approver}}<br>
                <strong>Remarks: </strong>{{$remarks}}<br>
            </p>
            <i>For more details you can click below: <br>
                <a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/view">Office Access</a>
            <br><a href="http://127.0.0.1:8000/reiss/quotation/check/{{$ref_no}}/view">Public Access</a>
            </i>
        @break
    @endswitch
    @endif
@endif