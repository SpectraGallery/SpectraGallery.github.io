<?php

include('mailchimp/mailchimp.php');

// Step 1 - Enter your Mailchimp API KEY - more info: http://kb.mailchimp.com/article/where-can-i-find-my-api-key
$apiKey 	= '';

// Step 2 - Enter your Mailchimp ListId code - more info: http://kb.mailchimp.com/article/how-can-i-find-my-list-id
$listId 	= '';


$email = $_POST['widget-subscribe-form-email'];
$firstname = isset( $_POST['widget-subscribe-form-firstname'] ) ? $_POST['widget-subscribe-form-firstname'] : '';
$lastname = isset( $_POST['widget-subscribe-form-lastname'] ) ? $_POST['widget-subscribe-form-lastname'] : '';

$MailChimp = new \Drewm\MailChimp($apiKey);

if(isset($email) AND $email != '') {
            
    $result = $MailChimp->call('lists/subscribe', array(
                    'id'                => $listId,
                    'email'             => array('email'=>$email),
                    'merge_vars'        => array('FNAME'=>$firstname, 'LNAME'=>$lastname), 
                    'double_optin'      => false,
                    'update_existing'   => false,
                    'replace_interests' => false,
                    'send_welcome'      => false,
                ));

    if (in_array('error', $result)) {
        $arrResult = array ('response'=>'error','message'=>$result['error']);
    } else {
        $arrResult = array ('response'=>'success');
    }

    echo json_encode($arrResult);
}

?>
