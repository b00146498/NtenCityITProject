<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $doctorName;
    public $appointmentDate;
    public $appointmentTime;
    public $appointmentId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientName, $doctorName, $appointmentDate, $appointmentTime, $appointmentId)
    {
        $this->clientName = $clientName;
        $this->doctorName = $doctorName;
        $this->appointmentDate = $appointmentDate;
        $this->appointmentTime = $appointmentTime;
        $this->appointmentId = $appointmentId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Confirmation')
                   ->view('emails.appointment-confirmation');
    }
}
