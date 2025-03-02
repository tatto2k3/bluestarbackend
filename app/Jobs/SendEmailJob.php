<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Handle\UtilsEmail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pdfContent;
    protected $customerName;
    protected $customerEmail;

    public function __construct($pdfContent, $customerName, $customerEmail)
    {
        $this->pdfContent = $pdfContent;
        $this->customerName = $customerName;
        $this->customerEmail = $customerEmail;
    }

    public function handle()
    {
        // Gửi email sử dụng UtilsEmail
        UtilsEmail::sendEmail(
            '20521081@gm.uit.edu.vn', // Điền email của bạn
            'ngotattopq@gmail.com',
            'Subject',
            'Body of the email', // Thay đổi nội dung email tùy ý
            $this->pdfContent,
            '20521081@gm.uit.edu.vn', // Điền email của bạn
            'kmmahzghwsdxcohc' // Điền mật khẩu email của bạn
        );
    }
}
