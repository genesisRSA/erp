<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $page;
    public $status;
    public $receiver;
    public $approver;
    public $ref_no;
    public $leave_type;
    public $requestor;
    public $remarks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$page,$status,$receiver,$approver,$ref_no,$leave_type,$requestor,$remarks = '')
    {
        $this->subject = $subject;
        $this->page = $page;
        $this->status = $status;
        $this->receiver = $receiver;
        $this->approver = $approver;
        $this->ref_no = $ref_no;
        $this->leave_type = $leave_type;
        $this->requestor = $requestor;
        $this->remarks = $remarks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail')
                    ->subject($this->subject)
                    ->with(array(
                        'page' => $this->page,
                        'status' => $this->status,
                        'receiver' => $this->receiver,
                        'approver' => $this->approver,
                        'ref_no' => $this->ref_no,
                        'leave_type' => $this->leave_type,
                        'requestor' => $this->requestor,
                        'remarks' => $this->remarks
                    ));
    }
}
