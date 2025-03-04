<?php

// Function to send data via cURL
function sendData($data)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://janicez87.sg-host.com/endpoint.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic am9tZWpvdXJuZXl3ZWJzaXRlQGdtYWlsLmNvbTpQQCQkd29yZDA5MDIxOGxlYWRzISM='
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

// Function to fetch user's IP address
function fetchIp()
{
    $url = "https://api.ipify.org/?format=json";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return false;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if ($data !== null) {
        return $data['ip'];
    } else {
        return false;
    }
}

// Function to check for junk content
function checkJunk($data)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://jomejourney.cognitiveservices.azure.com/contentmoderator/moderate/v1.0/ProcessText/Screen',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/plain',
            'Ocp-Apim-Subscription-Key: 453fe3c404554800bc2c22d7ef681542'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

function sendDiscordMsg($data)
{
    $post_array = array(
        "content" => $data,
        "embeds" => null,
        "attachments" => []
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(

        CURLOPT_URL => 'https://discord.com/api/webhooks/1343431986500468776/w-BlxCZetuhrjsIPWbHCs9qPCUUV04nT3AsQCL9VCrFt4_LdmbPV7JrVke_xmAeYmCwQ',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($post_array),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: __dcfduid=8ec71370974011ed9aeb96cee56fe4d4; __sdcfduid=8ec71370974011ed9aeb96cee56fe4d49deabe12bc0fc3d686d23eaa0b49af957ffe68eadec722cff5170d5c750b00ea'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

// Function to send frequency lead
function sendFrequencyLead($data)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://roundrobin.datapoco.ai/api/lead_frequency/add_lead',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode('Client Management Portal:123456')
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function sendLeadToDiscord($user)
{
    // echo json_encode($_POST); 

    $Project = "";
    $ProjectData = "";
    $ZapierURL = "";
    $commonData = array();
    $additional_data = array();

    // Modification for janicez557 cron
    if (isset($user)) {
        $commonData = array(
            "name" => $user['name'],
            "mobile_number" => $user['phone'],
            "email" => $user['email'],
            "source_url" => 'https://launchgovtest.homes/',
        );

        $additional_data = array(
            array(
                "key" => "Who will be included in your EC purchase?",
                "value" => $user['household']
            ),
            array(
                "key" => "Does your household include a Singapore Citizen?",
                "value" => $user['citizenship']
            ),
            array(
                "key" => "Are you and/or your co-applicants of eligible age?",
                "value" => $user['requirement']
            ),
            array(
                "key" => "Is your combined household income below $16,000?",
                "value" => $user['household_income']
            ),
            array(
                "key" => "Do you or any co-applicants currently own an HDB flat that has completed the Minimum Occupation Period (MOP)?",
                "value" => $user['ownership_status']
            ),
            array(
                "key" => "Have you or any co-applicants owned or disposed of any private property in the past 30 months?",
                "value" => $user['private_property_ownership']
            ),
            array(
                "key" => "Is this your first application for an HDB/EC property?",
                "value" => $user['first_time_applicant']
            ),
       );

        $commonData['additional_data'] = $additional_data;
        $LeadManagement = $commonData;

        // JSON encode the lead data
        $jsonData = json_encode($LeadManagement);

        // Check for potential junk content
        $check_junk = checkJunk($jsonData);

        // Fetch the user's IP address
        $ip_address = fetchIp();

        // Prepare webhook data
        $webhook_data = array(
            'client_id' => null,
            'project_id' => null,
            'ip_address' => $ip_address,
            'is_verified' => 0
        );

        // Determine status based on junk content
        if (isset($check_junk['Terms']) && !empty($check_junk['Terms']) && count($check_junk['Terms']) > 0) {
            $webhook_data['status'] = 'junk';
            $webhook_data['is_send_discord'] = 0;
        } else {
            $webhook_data['status'] = 'clear';
            $webhook_data['is_send_discord'] = 1;
            // Assuming sendFrequencyLead() is defined elsewhere
            sendFrequencyLead($LeadManagement);
            sendDiscordMsg($webhook_data);
            $_SESSION['lead_sent'] = true;
        }

        // Merge $_POST data with webhook data
        $webhook_data = array_merge($webhook_data, $_POST);

        // Send data to the endpoint
        sendData($webhook_data);
        return true;
    }
}

?>
