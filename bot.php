<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');
$channelAccessToken = 'ZcGFUmwnakcN26vB7LroNkT1a6E2+PVy9KBDwxGx7FaD9RUo5Y4XK7lN8C5rO3BxC0KFOXEcYb4vG1RUhjs59SfO+Mo+3WGTmHrH/XHakUt5RNuhDuuZgKnRPiwwQzc3+SzKKYne7nTgOkBCICYZ3AdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = 'b2c051813a3be3e6f0018e56b430e707';//sesuaikan
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
$key = 'm9NYsr-fKud~Sxgctdvkj0C1FOewZLAg3Krz8UI9'; //API SimSimi
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
