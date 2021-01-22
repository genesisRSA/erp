@if($page=="leave")
   @if($status=="filed" && $receiver=="approver")
        <h1>Good day, {{$approver}}</h1>
        <p>Please see below leave request for your approval:<br><br>
           <strong>Ref. No: </strong>{{$ref_no}}<br>
           <strong>Requested By: </strong>{{$requestor}}<br><br><br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/leaves/{{$ref_no}}/approval">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/leaves/{{$ref_no}}/approval">Public Access</a>
        </i>
   @elseif($status=="fit" && $receiver=="filer")  
        <h1>Good day, {{$requestor}}</h1>
        <p>You are fit to work:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/leave/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/leave/{{$ref_no}}">Public Access</a>
        </i>
   @elseif($status=="approved" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your leave request has been approved:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/leave/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/leave/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="declined" && $receiver=="filer")
            <h1>Good day, {{$requestor}}</h1>
            <p>Your leave request has been declined:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Approved By: </strong>{{$approver}}<br>
                <strong>Remarks: </strong>{{$remarks}}<br>
            </p>
            <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/leave/{{$ref_no}}">Office Access</a>
            <br><a href="http://124.105.224.123:8000/hris/leave/{{$ref_no}}">Public Access</a>
            </i>
    @elseif($status=="posted" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your leave request has been posted:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/leave/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/leave/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="void" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your leave request has been voided:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/leave/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/leave/{{$ref_no}}">Public Access</a>
        </i>
   @endif
@elseif($page=="ob")
    @if($status=="filed" && $receiver=="approver")
            <h1>Good day, {{$approver}}</h1>
            <p>Please see below official business request for your approval:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Requested By: </strong>{{$requestor}}<br><br><br>
            </p>
            <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/obs/{{$ref_no}}/approval">Office Access</a>
            <br><a href="http://124.105.224.123:8000/hris/obs/{{$ref_no}}/approval">Public Access</a>
            </i>
    @elseif($status=="manager" && $receiver=="approver")
        <h1>Good day, {{$approver}}</h1>
        <p>Please see below official business request for your approval:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Requested By: </strong>{{$requestor}}<br><br><br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/obs/{{$ref_no}}/approval">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/obs/{{$ref_no}}/approval">Public Access</a>
        </i>
    @elseif($status=="approved" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your official business request has been approved:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ob/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ob/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="declined" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your official business request has been declined:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ob/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ob/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="posted" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your official business request has been posted:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ob/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ob/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="void" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your official business request has been voided:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ob/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ob/{{$ref_no}}">Public Access</a>
        </i>
    @endif
@elseif($page=="cs")
    @if($status=="filed" && $receiver=="approver")
            <h1>Good day, {{$approver}}</h1>
            <p>Please see below change shift request for your approval:<br><br>
                <strong>Ref. No: </strong>{{$ref_no}}<br>
                <strong>Type: </strong>{{$leave_type}}<br>
                <strong>Requested By: </strong>{{$requestor}}<br><br><br>
            </p>
            <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/css/{{$ref_no}}/approval">Office Access</a>
            <br><a href="http://124.105.224.123:8000/hris/css/{{$ref_no}}/approval">Public Access</a>
            </i>
    @elseif($status=="manager" && $receiver=="approver")
        <h1>Good day, {{$approver}}</h1>
        <p>Please see below change shift request for your approval:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Type: </strong>{{$leave_type}}<br>
            <strong>Requested By: </strong>{{$requestor}}<br><br><br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/css/{{$ref_no}}/approval">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/css/{{$ref_no}}/approval">Public Access</a>
        </i>
    @elseif($status=="approved" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your change shift request has been approved:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/cs/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/cs/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="declined" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your change shift request has been declined:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/cs/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/cs/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="posted" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your change shift request has been posted:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/cs/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/cs/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="void" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your change shift request has been voided:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Type: </strong>{{$leave_type}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/cs/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/cs/{{$ref_no}}">Public Access</a>
        </i>
    @endif
@elseif($page=="ot")
    @if($status=="filed" && $receiver=="approver")
        <h1>Good day, {{$approver}}</h1>
        <p>Please see below overtime request for your approval:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Requested By: </strong>{{$requestor}}<br><br><br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ots/{{$ref_no}}/approval">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ots/{{$ref_no}}/approval">Public Access</a>
        </i>
    @elseif($status=="manager" && $receiver=="approver")
        <h1>Good day, {{$approver}}</h1>
        <p>Please see below overtime request for your approval:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Requested By: </strong>{{$requestor}}<br><br><br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ots/{{$ref_no}}/approval">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ots/{{$ref_no}}/approval">Public Access</a>
        </i>
    @elseif($status=="approved" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your overtime request has been approved:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ot/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ot/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="declined" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your overtime request has been declined:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ot/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ot/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="posted" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your overtime request has been posted:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ot/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ot/{{$ref_no}}">Public Access</a>
        </i>
    @elseif($status=="void" && $receiver=="filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your overtime request has been voided:<br><br>
            <strong>Ref. No: </strong>{{$ref_no}}<br>
            <strong>Approved By: </strong>{{$approver}}<br>
            <strong>Remarks: </strong>{{$remarks}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/hris/ot/{{$ref_no}}">Office Access</a>
        <br><a href="http://124.105.224.123:8000/hris/ot/{{$ref_no}}">Public Access</a>
        </i>
    @endif
@elseif($page=="digital signage")
    @if(($status==0 && $receiver == "approver") || ($status==2 && $receiver == "approver"))
        <h1>Good day, {{$approver}}</h1>
        <p>There is a digital signage for your approval:<br><br>
            <strong>Requested By: </strong>{{$requestor}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/ics/signages">Office Access</a>
        <br><a href="http://124.105.224.123:8000/ics/signages">Public Access</a>
        </i>
    @elseif($status==2 && $receiver == "filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your request is approved by HR:<br><br>
            <strong>Approved By: </strong>{{$approver}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/ics/signages">Office Access</a>
        <br><a href="http://124.105.224.123:8000/ics/signages">Public Access</a>
        </i>
    @elseif($status==1 && $receiver == "filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your request is approved and posted:<br><br>
            <strong>Approved By: </strong>{{$approver}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/ics/signages">Office Access</a>
        <br><a href="http://124.105.224.123:8000/ics/signages">Public Access</a>
        </i>
    @elseif($status==3 && $receiver == "filer")
        <h1>Good day, {{$requestor}}</h1>
        <p>Your request is rejected:<br><br>
            <strong>Rejected By: </strong>{{$approver}}<br>
        </p>
        <i>For more details you can click below: <br><a href="http://192.168.1.190:8000/ics/signages">Office Access</a>
        <br><a href="http://124.105.224.123:8000/ics/signages">Public Access</a>
        </i>
    @endif
@endif