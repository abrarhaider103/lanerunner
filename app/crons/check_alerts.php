<?php
include("../config.php");
include("cron_class.php");
include('../../vendor/autoload.php');

$logFile = 'cron-log.txt';

date_default_timezone_set('America/Chicago'); // Set timezone to CST
$current_time = strtotime('now');

// (8 AM and 1 PM CST)
$target_times = array(
    strtotime('today 8:00'),
    strtotime('today 13:00')
);

foreach ($target_times as $target_time) {
    if ($current_time >= $target_time && $current_time < ($target_time + 60)) {
        $content = "Cron task is running at " . date('H:i', $target_time) . " CST\n";
        file_put_contents($logFile, $content . "\n", FILE_APPEND);

        execute();
    }
}

function execute()
{
    global $ac;
    global $logFile;

    // get All the Records from schema
    $sql = "SELECT * FROM rate_change_alert WHERE 1";

    $al = $ac->getThisAll($sql);

    $uniqueFantasyNames = array(); // make data unique with fantasy name

    if (count($al) > 0) {

        foreach ($al as $value) {
            $equipment = $value->equipment;
            $main = $value->fantasy_name . "-" . $equipment;
            if (!isset($uniqueFantasyNames[$main])) {
                $uniqueFantasyNames[$main] = array(
                    'alert_id' => array($value->alert_id),
                    'direct_rate' => array($value->direct_rate),
                    'difference' => array($value->price_fluctuation),
                    'emails' => array($value->destination_email)
                );
            } else {
                $uniqueFantasyNames[$main]['alert_id'][] = $value->alert_id;
                $uniqueFantasyNames[$main]['direct_rate'][] = $value->direct_rate;
                $uniqueFantasyNames[$main]['difference'][] = $value->price_fluctuation;
                $uniqueFantasyNames[$main]['emails'][] = $value->destination_email;
            }
        }
        $curlData = array(); //required payload for api
        //make multi_dimensional array each of 12 as server accepts 12 requests at a time
        $chunkedUniqueFantasyNames = array_chunk($uniqueFantasyNames, 12, true);
        foreach ($chunkedUniqueFantasyNames as $fantasyRecords) {
            // Extract data from $fantasyValues array and make it as required for multicurl
            foreach ($fantasyRecords as $fantasyName => $fantasyValues) {
                $data = explode("-", $fantasyName);
                $curl = array(
                    'origin' => $data[0],
                    'destination' => $data[1],
                    'rental_type' => $data[2],
                );
                $curlData[] = $curl;
            }
            $curlResponse = array();
            $curlHandles = array();
            $apiEndpoint = 'http://161.35.216.210:5000/api/scrape';
            $headers = array(
                'Content-Type: application/json',
                'X-API-Key:1yjelvQ23WSVxZOyASfviZcRngSQ06qL3nVxzfYN'
            );
            // initialize multi_curl
            $multiHandle = curl_multi_init();
            foreach ($curlData as $record) {
                $curlHandle = curl_init($apiEndpoint);
                curl_setopt($curlHandle, CURLOPT_POST, true);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($record));
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

                curl_multi_add_handle($multiHandle, $curlHandle);
                $curlHandles[] = $curlHandle;
            }

            // Execute the multi-request
            do {
                $status = curl_multi_exec($multiHandle, $active);
                if ($status > 0) {
                    echo "cURL multi-exec error: " . curl_multi_strerror($status);
                }
                curl_multi_select($multiHandle);
            } while ($status === CURLM_CALL_MULTI_PERFORM || $active);
            // fetching curl response and sending emails
            foreach ($curlHandles as $curlHandle) {
                $response = curl_multi_getcontent($curlHandle); //fetching response from api\
                $responseData = json_decode($response);  //convert response
                // sending emails on matching records
                if (!isset($responseData->task->data)) {
                    $ac->reportRateError();
                    file_put_contents($logFile, "Skipped on null data: ". json_encode($responseData) . "\n", FILE_APPEND);
                    continue;
                }
                $responseTaskData = $responseData->task->data;
                $rate = $responseData->task->rate;
                if ($rate < 0 || $rate == null) {
                    continue;
                }
                $responseFantasyName = $responseTaskData->origin . "-" . $responseTaskData->destination . "-" . $responseTaskData->rental_type;
                // this loop will fetch array of 12 records and will match with fantasy name got from curl
                foreach ($fantasyRecords as $fantasyName => $fantasyValues) {
                    // for loop will run as single fantasy record may have multiple records as it is unique
                    for ($i = 0; $i < count($fantasyValues['alert_id']); $i++) {
                        // Access corresponding values for each record

                        if ($fantasyName == $responseFantasyName) {
                            $responseDirectRate = $responseData->task->rate;
                            $alertId = $fantasyValues['alert_id'][$i];
                            $directRate = $fantasyValues['direct_rate'][$i];
                            $difference = $fantasyValues['difference'][$i];
                            $email = $fantasyValues['emails'][$i];
                            // $responseDirectRate = (float) $responseDirectRate;
                            // $directRate = (float) $directRate;
                            $intResult = $responseDirectRate - $directRate;
                            $result = abs($intResult);
                            // var_dump('direct_rate: ',$directRate);
                            // echo "<br/>";
                            // var_dump('response_direct_rate: ',$responseDirectRate);
                            // echo "<br/>";
                            // var_dump('result : ',$result);
                            // echo "<br/>";
                            // var_dump('differenct : ',$difference);
                            // echo "<br/>";
                            if ($result >= $difference) {
                                $mail = new PHPMailer\PHPMailer\PHPMailer();
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host = MAIL_SERVER;
                                $mail->SMTPAuth = true;
                                $mail->Username = MAIL_USER;
                                $mail->Password = MAIL_PASS;
                                $mail->Port = MAIL_PORT;
                                $mail->SMTPSecure = "ssl";
                                $mail->setFrom(MAIL_USER, SITE_TITLE);
                                $mail->addAddress($email);
                                $mail->isHTML(true);
                                $mail->Subject = 'Rate Change Alert';
                                $mail->Body = 'This mail is to inform you that your ' . $difference . '$ alert criteria  for fantasy name ' . $fantasyName . ' has been met.';
                                if ($mail->send()) {
                                    // Update database to mark email sent
                                    $update_sql = "UPDATE rate_change_alert SET direct_rate = $responseDirectRate, updated_at = now(), condition_met = 1 WHERE alert_id = $alertId";
                                    $ac->doThis($update_sql);
                                    echo 'Email sent successfully!';
                                } else {
                                    echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
                                }

                            } else {
                                // echo "result not match";
                                echo "<br/>";
                            }
                        } else {
                            // echo "fantasy name not matched";
                            echo "<br/>";
                        }
                    }

                }
                curl_multi_remove_handle($multiHandle, $curlHandle);
                curl_close($curlHandle);
                curl_multi_close($multiHandle);
            }
            sleep(120);
            $curlData = array();
        }

    } else {
        echo "No Matching Data exists";
    }
}
