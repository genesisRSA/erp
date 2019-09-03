@if($page=="leave")
   @if($status=="filed" && $receiver=="approver")
        <h1>Good day, {{$approver}}</h1>
        <p>Please see below leave request for your approval:<br><br>
           <strong>Ref. No: </strong>{{$ref_no}}<br>
           <strong>Leave Type: </strong>{{$leave_type}}<br>
           <strong>Requested By: </strong>{{$requestor}}<br><br><br>
        </p>
        <i>For more details you can click <a href="http://localhost:8000/hris/leaves/{{$ref_no}}/approval">here.</a></i>
   @elseif($status=="fit" && $receiver=="filer")  
        <h1>Good day, {{$requestor}}</h1>
        <p>You are fit to work:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Leave Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click <a href="http://localhost:8000/hris/leave/{{$ref_no}}">here.</a></i>
   @elseif($status=="approved" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your leave request has been approved:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Leave Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click <a href="http://localhost:8000/hris/leave/{{$ref_no}}">here.</a></i>
    @elseif($status=="declined" && $receiver=="filer")
            <h1>Good day, {{$requestor}}</h1>
            <p>Your leave request has been declined:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Leave Type: </strong>{{$leave_type}}<br>
                <strong>Approved By: </strong>{{$approver}}<br>
                <strong>Remarks: </strong>{{$remarks}}<br>
            </p>
            <i>For more details you can click <a href="http://localhost:8000/hris/leave/{{$ref_no}}">here.</a></i>
    @elseif($status=="posted" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your leave request has been posted:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Leave Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click <a href="http://localhost:8000/hris/leave/{{$ref_no}}">here.</a></i>
   @endif
@endif