<?php

function sendLeadToDiscord($userId)
{
    // echo json_encode($_POST); 

    $Project = "";
    $ProjectData = "";
    $ZapierURL = "";
    $commonData = array();
    $additional_data = array();

    if (isset($_POST)) {
        $commonData = array(
            "name" => $_POST['firstname'],
            "mobile_number" => $_POST['ph_number'],
            "email" => $_POST['email'],
            "source_url" => 'https://findmypropertyvalaution.homes/',
        );

        if ($_POST['form_type'] == 'condo') {

            $data = 'New Lead Please take note! New Lead Please take note! 
    Jome Official, you have a new lead:
    - Source Url: https://findmypropertyvalaution.homes/
    - Name: '.$_POST['firstname'].'
    - Contact:  https://wa.me/+65'.$_POST['ph_number'].'
    - Email: '.$_POST['email'].'
    - Project: '.$_POST['condo_project_name'].'
    - Blk:  '.$_POST['blk'].'
    - Looking to sell your property: '.$_POST['sellCheck'].'
    - Floor - Unit number: '.$_POST['floorNumber'] ." - ". $_POST['unitNumber'].'';


            $additional_data = array(
                array(
                    "key" => "Project",
                    "value" => "Condo " . $_POST['condo_project_name']
                ),
                array(
                    "key" => "Blk",
                    "value" => $_POST['blk']
                ),
                array(
                    "key" => "Looking to sell your property",
                    "value" => $_POST['sellCheck']
                ),
                array(
                    "key" => "Floor - Unit number",
                    "value" => $_POST['floorNumber'] ." - ". $_POST['unitNumber']
                )
            );
        } elseif ($_POST['form_type'] == 'landed') {

            $data = 'New Lead Please take note! New Lead Please take note! 
    Jome Official, you have a new lead:
    - Source Url: https://findmypropertyvalaution.homes/
    - Name: '.$_POST['firstname'].'
    - Contact:  https://wa.me/+65'.$_POST['ph_number'].'
    - Email: '.$_POST['email'].'
    - Project: Landed
    - Landed Street:  '.$_POST['landed_street'].'
    - SQFT: '.$_POST['sqft'].'
    - Like to Know: '.implode(" | ", $_POST['like_to_know']).'
    - Plans: '.$_POST['your_plans'].'';

            $additional_data = array(
                array(
                    "key" => "Project",
                    "value" => "Landed"
                ),
                array(
                    "key" => "Landed Street",
                    "value" => $_POST['landed_street']
                ),
                array(
                    "key" => "SQFT",
                    "value" => $_POST['sqft']
                ),
                array(
                    "key" => "Like to Know",
                    "value" => implode(" | ", $_POST['like_to_know'])
                ),
                array(
                    "key" => "Plans",
                    "value" => $_POST['your_plans']
                )
            );
        } elseif ($_POST['form_type'] == 'hdb') {

            $data = 'New Lead Please take note! New Lead Please take note! 
    Jome Official, you have a new lead:
    - Source Url: https://findmypropertyvalaution.homes/
    - Name: '.$_POST['firstname'].'
    - Contact:  https://wa.me/+65'.$_POST['ph_number'].'
    - Email: '.$_POST['email'].'
    - Project: HDB
    - Town:  '.$_POST['town'].'
    - Street Name: '.$_POST['street_name'].'
    - Blk: '.$_POST['blk'].'
    - HDB Flat Type: '.$_POST['flat_type'].'
    - Looking to sell your property: '.$_POST['sellCheck'].'
    - Floor - Unit number: '.$_POST['floor_number'] ." - ".$_POST['unit_number'].'';

            $additional_data = array(
                array(
                    "key" => "Project",
                    "value" => "HDB"
                ),
                array(
                    "key" => "Town",
                    "value" => $_POST['town']
                ),
                array(
                    "key" => "Street Name",
                    "value" => $_POST['street_name']
                ),
                array(
                    "key" => "Blk",
                    "value" => $_POST['blk']
                ),
                array(
                    "key" => "HDB Flat Type",
                    "value" => $_POST['flat_type']
                ),
                array(
                    "key" => "Looking to sell your property",
                    "value" => $_POST['sellCheck']
                ),
                array(
                    "key" => "Floor - Unit number",
                    "value" => $_POST['floor_number'] ." - ".$_POST['unit_number']
                )
            );
        }

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
            //sendDiscordMsg($data);
            $_SESSION['lead_sent'] = true;
        }

        // Merge $_POST data with webhook data
        $webhook_data = array_merge($webhook_data, $_POST);

        // Send data to the endpoint
        sendData($webhook_data);
    }

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

            CURLOPT_URL => 'https://discord.com/api/webhooks/1337719676704133140/xYQPjnOeeEwNb1V6xmf6Gz3Y9m-AIfq-8Iqet61Y_FvQPukqOwGB1vbFJXxk9X7pnrg_',

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

        echo $response;
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
    }
}

?>
