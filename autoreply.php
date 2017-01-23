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
                    $text_out = getText($text_in);
                    // Build message to reply back
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
echo "Auto Reply Bot.";

function getText($text_in) {
    // Start check incoming message.
    if (strlen($text_in)==1) {
				
		switch ($text_in) {
			case '0':
				$text_out = "0: (moon grin)";
				break;
			case '1':
				$text_out = "1: (love)";
				break;
			case '2':
				$text_out = "2: (hee)";
				break;
			case '3':
				$text_out = "3: (sparkling eyes)";
				break;
			case '4':
				$text_out = "4: (tongue out)";
				break;
			case '5':
				$text_out = "5: (birthday)(birthday)";
				break;
			case '6':
				$text_out = "6: (heart)(heart)(heart)(heart)";
				break;
			case '7':
				$text_out = "7: (beer)(beer)(beer)";
			    break;
			case '8':
				$text_out = "8: (angry)";
				break;
			case '9':
				$text_out = "9: (love) (rose stalk)(rose stalk)(rose stalk)";
				break;
			default:
				$text_out = "(no)";
		}
	}
	elseif (strtoupper($text_in) == "HELP") {
		$text_out = "ต้องการให้ช่วยเรื่องอะไร? \nเพียงแค่พิมพ์ข้อความดังต่อไปนี้เลยคร๊าบ (moon grin) \n\n1.เมนู_1 \n2.เมนู_2 \n3.เมนู_3 \n4.เมนู_4 \n5.เมนู_5 \n6.เมนู_6 \n7.เมนู_7 \n8.เมนู_8 \n9.เมนู_9 \n0.เมนู_0 \n\n(heart)\n และหากต้องการความช่วยเหลือด่วนติดต่อได้ 24 ชั่วโมง ที่นี่เลย \n(phone) 02-222-3333";
	}
	else {
		$text_out = $text_in;
	}

    return $text_out;
}

function getSticker() {
     $sticker = array(  'type' => 'sticker',
                        'packageId' => '4',
                        'stickerId' => '300' );
     return $sticker;
}
