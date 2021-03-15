<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $page;
    public $status;
    public $receiver;
    public $approver;
    public $ref_no;
   // public $details;
    public $requestor;
    public $remarks;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$page,$status,$receiver,$approver,$ref_no,$requestor,$remarks = '',$id)
    {
        $this->subject = $subject;
        $this->page = $page;
        $this->status = $status;
        $this->receiver = $receiver;
        $this->approver = $approver;
        $this->ref_no = $ref_no;
        // $this->details = $details;
        $this->requestor = $requestor;
        $this->remarks = $remarks;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('salesmail')
                    ->subject($this->subject)
                    ->with(array(
                        'page' => $this->page,
                        'status' => $this->status,
                        'receiver' => $this->receiver,
                        'approver' => $this->approver,
                        'ref_no' => $this->ref_no,
                        // 'details' => $this->details,
                        'requestor' => $this->requestor,
                        'remarks' => $this->remarks,
                        'id' => $this->id,
                    ));
    }
}
