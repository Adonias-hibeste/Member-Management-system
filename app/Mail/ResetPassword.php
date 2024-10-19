<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $newPassword;
    /**
     * Create a new message instance.
     *
     * @param $user
     *@param $newPassword
     */
    public function __construct($user , $newPassword)
    {
        $this->user =$user;
        $this->newPassword=$newPassword;

    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Reset Password',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Build the message
     *
     * @return $this
     */

     public function build(){
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject('Password Reset')
                    ->view('email.ResetPassword')
                    ->with([
                        'user'=> $this->user,
                        'newPassword'=>$this->newPassword
                    ]);
     }

}
