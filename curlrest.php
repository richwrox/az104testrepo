<?php
include 'restAuth.php';    // tickets tokons and secure data
function myCurl($curlAuth, $curlData, $curlAddress) {
    $curl = curl_init();    // echo $addr . $data . "\r\n"; //debug
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => false,    //disables ssl server cert verify check
        CURLOPT_SSL_VERIFYHOST => false,    //disables ssk host cert verify check
        CURLOPT_URL => $curlAddress . $curlData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 300,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => $curlAuth, //restAuth contains the auth Tokens. This also need to be update to return JSON instead of include
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return $response;
    } 
}

if (isset($_GET['curlData']) & isset($_GET['curlAddress'])) {
    $curlAuth = $apicAuth;
    $curlData = $_GET['curlData'];
    $curlAddress = $_GET['curlAddress'];       
    $reponse = $myCurl($curlAuth, $curlData, $curlAddress)
    if ($array['http-code'] == 500) {
        echo print_r($array);
    } else { 
        $json = json_decode($response, true);
        //print_r($json);  // debug
        //echo $response;  // debug
        //echo $json['vlanId']['associationTime']; // debug
        $match = array("NAS Interface :"=>'clientInterface',"NAS Connection Type :"=>'connectionType',    
                       "NAS IP :"=>'deviceIpAddress',"NAS Name :"=>'deviceName',                    
                       "EndPoint Type :"=>'deviceType',"EndPoint IP :"=>'ipAddress',                      
                       "EndPoint MAC :"=>'macAddress',"EndPoint NAC :"=>'securityPolicyStatus',
                       "EndPoint OUI :"=>'vendor',"EndPoint VLAN:"=>'vlan');
        //echo $json['queryResponse']['entity']['0']['clientsDTO']['securityPolicyStatus'] . "\r\n";   // debug
        //echo print_r($json) . "\r\n";    // debug
        if (isset($json['queryResponse']['entity'])) { 
            for ($i = 0; $i < count($json['queryResponse']['entity']); $i++) {
                //Debug
                //echo "How many response: " . count($json['response']) . "<br>";
                echo "<br>";
                echo "Array Element: " . $i . "<br>";  
                echo "<br>";    
                foreach ($match as $x => $item) {
                    echo "<b>" . $x . "</b>" . "  " . $json['queryResponse']['entity']['0']['clientsDTO'][$item] . "<br>";    
                } 
        
            }   
            echo "<p>" . "</p>";
            echo "<p>" . "</p>";
        } else {
            echo "Unable to locate record for : " . "<font color=\"red\">" . $data . "</font>";
            echo "<p>" . "</p>"; 
            echo "<p>" . "</p>";
        }
    }   
}
?>
