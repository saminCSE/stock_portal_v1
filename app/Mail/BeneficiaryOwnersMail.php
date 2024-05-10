<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BeneficiaryOwnersMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $pdf;
     public $beneficiaryOwners;

     public function __construct($pdf, $beneficiaryOwners)
     {
         $this->pdf = $pdf;
         $this->beneficiaryOwners = $beneficiaryOwners;
     }

     /**
      * Build the message.
      *
      * @return $this
      */
     public function build()
     {


         return $this->subject('Beneficiary Owners PDF')
             ->view('emails.beneficiary_owners_mail')
             ->with('beneficiaryOwners', $this->beneficiaryOwners)
             ->attachData($this->pdf->output(), 'beneficiary-owners.pdf');
     }

}
