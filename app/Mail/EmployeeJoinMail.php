<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeJoinMail extends Mailable
{
    use SerializesModels;

    public $user; // This will hold the data for the user you created

    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('translation.welcome_to_etikaf')) // Subject of the email
            ->view('mails.employee_join_mail', ['user' => $this->user]); // View for the email content
    }
}
