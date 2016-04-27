# Installation 

### Files

* config.php

once cloned, create a file called "config.php" and add the following with your details in place of the placeholder values

```php
<?php
	//Configuration File
	//key=>secret
	$config = array(
		'lti_keys'=>array(
			'YOUR_CLIENT_KEY'=>'YOUR_CLIENT_SECRET'
		),
		'use_db'=>true,
		'db'=>array(
			'driver'=>'mysql',
			'hostname'=>'localhost',
			'username'=>'YOUR_DB_USERNAME',
			'password'=>'YOUR_DB_PASSWORD',
			'dbname'=>'YOUR_DB_NAME',
		)
	);
?>
```

* lib/grade.php

create this file using the following code. You will need to add your client secret as shown below to allow for grade return

```php
<?php

        function send_grade($grade,$lti){
                $method="POST";
                $sourcedid = $lti->result_sourcedid();
                if (get_magic_quotes_gpc()) $sourcedid = stripslashes($sourcedid);
                $oauth_consumer_key = $lti->lti_id();
                $oauth_consumer_secret = 'YOUR SECRET';
                $endpoint = $lti->grade_url();
                $content_type = "application/xml";
                $operation = 'replaceResultRequest';
                $messageIdent = $_SERVER['REQUEST_TIME'];
                $body = '<?xml version = "1.0" encoding = "UTF-8"?>  
                <imsx_POXEnvelopeRequest xmlns = "http://www.imsglobal.org/services/ltiv1p1/xsd/imsoms_v1p0">      
                    <imsx_POXHeader>         
                        <imsx_POXRequestHeaderInfo>            
                            <imsx_version>V1.0</imsx_version>  
                            <imsx_messageIdentifier>'.$messageIdent.'</imsx_messageIdentifier>         
                        </imsx_POXRequestHeaderInfo>      
                    </imsx_POXHeader>      
                    <imsx_POXBody>         
                        <'.$operation.'>            
                            <resultRecord>
                                <sourcedGUID>
                                    <sourcedId>'.$sourcedid.'</sourcedId>
                                </sourcedGUID>
                                <result>
                                    <resultScore>
                                        <language>en-us</language>
                                        <textString>'.$grade.'</textString>
                                    </resultScore>
                                </result>
                            </resultRecord>       
                        </'.$operation.'>      
                    </imsx_POXBody>   
                </imsx_POXEnvelopeRequest>';
                $hash = base64_encode(sha1($body, TRUE));
                        $params = array('oauth_body_hash' => $hash);
                $token = '';
                $hmac_method = new OAuthSignatureMethod_HMAC_SHA1();
                $consumer = new OAuthConsumer($oauth_consumer_key, $oauth_consumer_secret);
                $outcome_request = OAuthRequest::from_consumer_and_token($consumer, $token, $method, $endpoint, $params);
                //return $outcome_request;
                $outcome_request->sign_request($hmac_method, $consumer, $token);
                $header = $outcome_request->to_header();
                $header = $header . "\r\nContent-type: " . $content_type . "\r\n";
                $options = array(
                        'http' => array(
                                'method' => 'POST',
                                'content' => $body,
                                'header' => $header,
                        ),
                );
                $ctx = stream_context_create($options);
                $fp = @fopen($endpoint, 'rb', FALSE, $ctx);
                $response = @stream_get_contents($fp);

        }


?>

```


# Setup
1. Edit config.php with your respective LTI keys and optional database details
2. Host on a https server (LTI with edX requires HTTPS)
3. Add the respective keys in the edX advanced settings
4. Create a new LTI component and point it to the correct URL

# Usage
1. use test.php with LTI to confirm that everything is connecting
2. on each page, include <?php require_once('inc/header.php'); ?> at the top
3. to ensure valid LTI, make sure to run $lti->requirevalid(); directly after header.php

# Testing
For testing we recommend the LTI 1.1 testbed, available at: http://www.imsglobal.org/developers/LTI/test/v1p1/lms.php
