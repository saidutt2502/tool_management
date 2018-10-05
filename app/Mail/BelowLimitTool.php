<?php

namespace App\Mail;
use App\Issue_tool;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BelowLimitTool extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	 
	 public $issue_tool;
	 
    public function __construct(Issue_tool $issue_tool)
    {
        //
		$this->issue_tool = $issue_tool;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		 $subject = 'Re-order of tool';
        return $this->view('emails.mail')
				->subject($subject);
               
    }
	
	
}
