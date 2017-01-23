<?php
$access_token = '+iEjRFtp16exBGaNleTlwMtIRqyQvzy4KyNrSOQMlsUERuEbj6W6RruPm7RShfVS9ABUcXWK8xj4fRTm0xKnX66A0MnErwGx+AhlRjlULfn5rhH27tRw/9Dg8hKID5u41WKN0ykvNOLH2BxeRsohfQdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
        // Get replyToken
		$replyToken = $event['replyToken'];
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message') {
			
            // Processing by message type.
            switch ($event['message']['type']) {
                case 'text':
                    // Get message in.
			        $text_in = $event['message']['text'];

                    // $ret = isStrickerMapping($text_in);
                    // if ($ret == TRUE) {
                    //     $messages = getStrickerMapping($text_in);
                    //     break;
                    // }

                    // Check wording and Build Sticker to reply back.
                    $ret = getStrickerMapping($text_in);
                    if ($ret == TRUE) {
                        $messages = $sticker_map;
                        break;
                    }
                    
                    // Build message to reply back
                    $text_out = getText($text_in);
                    $messages = [
                            'type' => 'text',
                            'text' => $text_out
                    ];                                 
                    break;

                case 'image':
                    $text_out = "ขอบคุณครับ สำหรับรูปภาพ";
                    $messages = [
				        'type' => 'text',
				        'text' => $text_out
			        ];                  
                    break;

                case 'video':
                    $text_out = "ขอบคุณครับ สำหรับคลิปวีดีโอ";                
                    $messages = [
				        'type' => 'text',
				        'text' => $text_out
			        ];                  
                    break;

                case 'audio':
                    $text_out = "ขอบคุณครับ สำหรับคลิปเสียง";                
                    $messages = [
				        'type' => 'text',
				        'text' => $text_out
			        ];                  
                    break;

                case 'location':
                    $text_out = "ขอบคุณครับ สำหรับการแจ้งพิกัดของคุณ";
                    $messages = [
				        'type' => 'text',
				        'text' => $text_out
			        ];                  
                    break;

                case 'sticker':
                    // Build sticker to reply back
                    $messages = getSticker();
                    break;
            }            

			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);			

			echo $result . "\r\n";
		}
	}
}
echo "Auto Reply Bot: " . rand(1000, 9999);

function getText($text_in) {
    // Start check incoming message.
    if (strlen($text_in)==1) {
				
		switch ($text_in) {
			case '0':
				$text_out = "0: 􀂳";
				break; 
			case '1':
				$text_out = "1: 􀂴";
				break;
			case '2':
				$text_out = "2: Hello, world 􀂲";
				break;
			case '3':
				$text_out = "3: 􀂵";
				break;
			case '4':
				$text_out = "4: 􀂶";
				break;
			case '5':
                $text_out = "5: 􀁙 􀁖";
				break;
			case '6':
				$text_out = "6: 􀀷 􀀷 􀀷 􀀷";
				break;
			case '7':
				$text_out = "7: http://www.google.co.th";
			    break;
			case '8':
				$text_out = "8: TV-Online http://www.inwbungyee.com";
				break;
			case '9':
				$text_out = "9: FB http://www.facebook.com";
				break;
			default:
				$text_out = "􀂦";
		}
	}
	elseif (strtoupper($text_in) == "HELP") {
		$text_out = "ต้องการให้ช่วยเรื่องอะไร? \nเพียงแค่พิมพ์ข้อความดังต่อไปนี้เลยคร๊าบ 􀂍 \n\n1.เมนู_1 \n2.เมนู_2 \n3.เมนู_3 \n4.เมนู_4 \n5.เมนู_5 \n6.เมนู_6 \n7.เมนู_7 \n8.เมนู_8 \n9.เมนู_9 \n0.เมนู_0 \n\n 􀀷 \n และหากต้องการความช่วยเหลือด่วนติดต่อได้ 24 ชั่วโมง ที่นี่เลย \n 􀀼  02-222-3333";
	}
	else {
		$text_out = $text_in;
	}

    return $text_out;
}

function getSticker() {

    $sticker_package = rand(1, 4);
    if ($sticker_package == 1) {
        $sticker_id = rand(1, 430);
        if ($sticker_id > 21) {
            $sticker_id = rand(100, 430);
            if ($sticker_id > 139) {
                $sticker_id = rand(401, 430);
            }
        }
    }
    elseif ($sticker_package == 2) {
        $sticker_id = rand(18, 527);
        if ($sticker_id > 47) {
            $sticker_id = rand(140, 527);
            if ($sticker_id > 179) {
                $sticker_id = rand(501, 527);
            }
        }
    }
    elseif ($sticker_package == 3) {
        $sticker_id = rand(180, 259);        
    }
    elseif ($sticker_package == 4) {
        $sticker_id = rand(260, 632);
        if ($sticker_id > 307) {
            $sticker_id = rand(601, 632);
        }
    }

    $sticker = array(  'type' => 'sticker',
                        'packageId' => $sticker_package,
                        'stickerId' => $sticker_id );
    return $sticker;
}

// function isStrickerMapping($text_in) {
    
//     switch ($text_in) {
// 		case 'รัก':
// 		case 'รักเธอ':
//         case 'love':
//             $ret = TRUE;	
// 			break;
//         default: 
//             $ret = FALSE;
//     }
//     return $ret;
// }

function getStrickerMapping($text_in) {

    global $sticker_map;

    switch ($text_in) {
		case 'รัก':
		case 'รักเธอ':
            $sticker_package = 1;
            $sticker_id = 410;
            break;
        case 'love':
        case 'love you':
            $sticker_package = 3;
            $sticker_id = 180;
            break;
        default: 
            return FALSE;
    }

    $sticker_map = array(  'type' => 'sticker',
                           'packageId' => $sticker_package,
                           'stickerId' => $sticker_id );
    return TRUE;
}

