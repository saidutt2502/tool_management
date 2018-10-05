<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Breakdown extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mailData;
     
   public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $subject = 'Machine Breakdown Intimation';
         
         
         // $input =  $this->mailData ;  
          
           // Array for Blade
                $input = array(
                                  'number'     => $this->mailData['number'],
                                  'dept'  => $this->mailData['department'],
                                  'added_by'     => $this->mailData['added_by'],
                                  'type'     => $this->mailData['type'],
                                  
                                  
                              );
                              
         
        return $this->view('emails.breakdownintimation')
                ->subject($subject)->withInputs($input);
    }
}
