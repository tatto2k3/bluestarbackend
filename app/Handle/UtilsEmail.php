<?php

namespace App\Handle;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use TCPDF;
use Datetime;
use Dompdf\Dompdf;
use Dompdf\Options;
class UtilsEmail
{
    public static function createPdfDocument($amount, $CustomerName, $CustomerIdentify, $SeatID, $FlightID, $DepeartureDay, $ArriveDay, $DepeartureTime, $ArriveTime, $CustomerPhone, $TimeDuration, $TripType)
    {
        // Tạo HTML cho PDF

// Rest of your PHP code

    $html = "<html><head>";
    $html .= "<style>";
    $html .= "body { font-family: 'Inter', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }";
    $html .= ".container { width: 80%; margin: auto; }"; // Container layout
    $html .= ".header { background-color: #4285f4; color: #fff; padding: 20px; text-align: center; }"; // Header color and layout
    $html .= ".content { padding: 20px; background-color: #fff; border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px; }"; // Content color and layout
    $html .= "h1, p { color: #333; }"; // Title and text color
    $html .= "</style>";
    $html .= "</head><body>";
    $html .= "<div class='container'>";
    $html .= "<div class='header'>";
    $html .= "<h1>Airline Ticket Information</h1>";
    $html .= "</div>";
    $html .= "<div class='content'>";
    $html .= "<p>Customer Name: $CustomerName</p>";
    $html .= "<p>ID Card: $CustomerIdentify</p>";
    $html .= "<p>Seat: $SeatID</p>";
    $html .= "<p>Flight Code: $FlightID</p>";
    $html .= "<p>Departure Date: $DepeartureDay</p>";
    $html .= "<p>Arrival Date: $ArriveDay</p>";
    $html .= "<p>Departure Time: $DepeartureTime</p>";
    $html .= "<p>Arrival Time: $ArriveTime</p>";
    $html .= "<p>Phone Number: $CustomerPhone</p>";
    $html .= "<p>Flight Duration: $TimeDuration</p>";
    $html .= "</div>";
    $html .= "</div>";
    $html .= "</body></html>";



        // Khởi tạo Dompdf
        $pdfPassword = $CustomerIdentify;
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);


        // Cấu hình và render PDF
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Gửi email
        $subject = 'Thong tin ve may bay';
        $body = 'Xin chào, cảm ơn quý khách đã sử dụng dịch vụ chúng tôi. Chúng tôi xin gửi chi tiết thông tin vé máy bay. Chúc quý khách có một chuyến bay thú vị.';
        $from = '20521081@gm.uit.edu.vn'; // Điền địa chỉ email của bạn
        $recipients = 'ngotattopq@gmail.com'; // Điền địa chỉ email của người nhận

        // Tạo attachment từ PDF
        $attachment = $dompdf->output();
        $attachmentName = 'ticket.pdf';

        // Gửi email với attachment
        self::sendEmail($from, $recipients, $subject, $body, $attachment, '20521081@gm.uit.edu.vn', 'kmmahzghwsdxcohc');
    }

    public static function sendEmail($from, $recipients, $subject, $body, $attachment, $username, $password)
    {
        try {
            $emailMessage = new PHPMailer();
            $emailMessage->setFrom($from);
            $emailMessage->addAddress($recipients);
            $emailMessage->Subject = $subject;
            $emailMessage->isHTML(true);
            $emailMessage->Body = $body;
            $emailMessage->addStringAttachment($attachment, 'ticket.pdf', 'base64', 'application/pdf');

            $emailMessage->isSMTP();
            $emailMessage->Host = 'smtp.gmail.com';
            $emailMessage->Port = 587;
            $emailMessage->SMTPSecure = 'tls';
            $emailMessage->SMTPAuth = true;
            $emailMessage->Username = $username;
            $emailMessage->Password = $password;

            $emailMessage->send();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public static function formatTimeDuration($departureTime, $arrivalTime)
    {
        $departureDate = DateTime::createFromFormat('H:i', $departureTime);
        $arrivalDate = DateTime::createFromFormat('H:i', $arrivalTime);

        $duration = $departureDate->diff($arrivalDate);
        $hours = abs($duration->h);
        $minutes = abs($duration->i);
        $seconds = abs($duration->s);

        $formattedDuration = "{$hours} hr";

        if ($minutes > 0) {
            $formattedDuration .= " {$minutes} min";
        }

        if ($seconds > 0) {
            $formattedDuration .= " {$seconds} sec";
        }

        return $formattedDuration;
    }

    private static function renderTemplate($path, $data)
    {
        ob_start();
        extract($data);
        include($path);
        return ob_get_clean();
    }
}
