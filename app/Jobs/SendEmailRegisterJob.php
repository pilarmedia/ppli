<?php

namespace App\Jobs;

use Throwable;
use Swift_Mailer;
use SmtpTransport;
use Swift_Message;
use Exception;
use Swift_SmtpTransport;
use App\Models\Email;
use Illuminate\Mail\Mailer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailRegisterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $details)
    {
        $this->details = $details;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Email::firstOrFail();
        $transport = (new Swift_SmtpTransport($data->host, $data->port, $data->encryption))
        ->setUsername($data->username)
        ->setPassword($data->password);
        $mailer = new Swift_Mailer($transport);
         $message = (new Swift_Message($data->receipt_subject))
        ->setFrom([ $data->username=> $data->name])
        ->setTo([$this->details['email'] => $this->details['name']])
        ->setBody('saudara '.$this->details['name'].' '.$this->details['mail'], 'text/html');
        $result = $mailer->send($message);


        $message2 = (new Swift_Message($data->receipt_subject))
                ->setFrom([ $data->username=> $data->name])
                ->setTo([$this->details['tujuan_email']=> $this->details['tujuan_name']])
                ->setBody($this->details['tujuan_mail'].' saudara '.$this->details['name'], 'text/html');

            $result2 = $mailer->send($message2);
    }
}
