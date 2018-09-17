<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');
$channelAccessToken = 'ZUJW7fbRDcLaJa/gxleUSBkPoQU8xU46S6jecqEXSYpOc2sDrtWL2vC8vZ3QbjfEGBuBmzPncbsmrDGP7SH0SFiNE+KZ3texYrirn4/4pnKM0S9i2fYcZ+CdC66hrTAR3wGE+xAVaTw7iHwVI0k88wdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = 'f7b841dafb03c3ff6fc7969832ca4c21';//sesuaikan
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];
if($message['type']=='kontak')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => ' '										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'd731b57f-09d4-4cad-a9ce-907260b86c2d'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);
file_put_contents('./reply.json',$result);
$client->replyMessage($balas);
