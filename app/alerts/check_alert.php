<?php
include("/home/bitnami/htdocs/vendor/autoload.php");

include("/home/bitnami/htdocs/config.php");
include("/home/bitnami/htdocs/app/ajax/ajax_class.php");

$sql = "SELECT * FROM rate_change_alert WHERE 1";
$al = $ac->getThisAll($sql);


foreach ($al as $v) {
    $mail = 0;

    $trigger_high = $v->direct_rate + $v->price_fluctuation;
    $trigger_low = $v->direct_rate - $v->price_fluctuation;


    $sql = "SELECT reefer FROM lanes WHERE fantasy_name = '$v->fantasy_name'";
    echo $sql;
    $rate = $ac->getThis1($sql);
    $current_rate = $rate->reefer;

    echo "<pre>";
    print_r($rate);
    exit;

    if ((int)$current_rate > (int)$trigger_high) {
        $mail = 1;
        $new_val = $trigger_high;
    }
    if ((int)$current_rate < (int)$trigger_low) {
        $mail = 1;
        $new_val = $trigger_high;
    }

    if ($mail === 1) {

        var_dump($current_rate);
        exit;

        $sql = "UPDATE rate_change_alert SET direct_rate = $new_val WHERE alert_id = $v->alert_id";
        // $ac->doThis($sql);



        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = MAIL_SERVER;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->Port = MAIL_PORT;                    //SMTP port
        $mail->SMTPSecure = "ssl";


        // Set the sender and recipient
        $mail->setFrom(MAIL_USER, 'Lanerunner Inc');
        $mail->addAddress('gutibs@gmail.com', 'Gustavo Silva');

        // Set email content
        $mail->isHTML(true);
        $mail->Subject = 'Your trigger reminder';
        $mail->Body = 'This is to let you know that the ' . $v->fantasy_name . ' price has reached your desired level of $ ' . $new_val;

        // Send the email
        if ($mail->send()) {
            echo 'Email sent successfully!';
        } else {
            echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
        }
    }
}

exit;
