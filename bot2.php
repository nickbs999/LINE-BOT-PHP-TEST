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
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
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

			if (strlen($result)==1) {
				
				switch ($result) {
					case '0':
						$result_out = "0: (moon grin)";
						break;
					case '1':
						$result_out = "1: (love)";
						break;
					case '2':
						$result_out = "2: (hee)";
						break;
					case '3':
						$result_out = "3: (sparkling eyes)";
						break;
					case '4':
						$result_out = "4: (tongue out)";
						break;
					case '5':
						$result_out = "5: (birthday)(birthday)";
						break;
					case '6':
						$result_out = "6: (heart)(heart)(heart)(heart)";
						break;
					case '7':
						$result_out = "7: (beer)(beer)(beer)";
						break;
					case '8':
						$result_out = "8: (angry)";
						break;
					case '9':
						$result_out = "9: (love) (rose stalk)(rose stalk)(rose stalk)";
						break;
					default:
						$result_out = "(no)";						
				}

			}
			elseif (strtoupper($result) == "HELP") {
				$result_out = "ต้องการให้ช่วยเรื่องอะไร \nเพียงแค่พิมพ์ข้อความดังต่อไปนี้เลยคร๊าบ (moon grin) \n\n1.เมนู_1 \n2.เมนู_2 \n3.เมนู_3 \n4.เมนู_4 \n5.เมนู_5 \n6.เมนู_6 \n7.เมนู_7 \n8.เมนู_8 \n9.เมนู_9 \n0.เมนู_0 \n\n(heart)\n และหากต้องการความช่วยเหลือด่วนติดต่อได้ 24 ชั่วโมง ที่นี่เลย \n(phone) 02-222-3333";
			}
			else {
				$result_out = $result;
			}

			echo $result_out . "\r\n";

		}
	}
}
echo 'OK BOT2 Test2';

