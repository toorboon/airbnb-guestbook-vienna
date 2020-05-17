<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataArray;

    /**
     * Create a new message instance.
     * @param $dataArray
     */
    public function __construct($dataArray)
    {
        $this->dataArray = $dataArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dataArray = $this->dataArray;
        return $this->from($dataArray['fromEmail'])
            ->view('mails.invite')
                    ->with('dataArray', $dataArray)
            ;
    }
}
