<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');
$channelAccessToken = 'Rf1Re6tnA1sY92LCo8KxZqVo9sOoG22CSpowZB2UbT8HBFUWL2VgObiLq30t/aGfGBuBmzPncbsmrDGP7SH0SFiNE+KZ3texYrirn4/4pnJ/LXbJyiIV5+raqDrvBrAKU8IUO4/4v/aw7zyIk+ALQgdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = '0328a12fc2018eb18b070ce55b33e1ad';//sesuaikan
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
$key = 'ygP6ZqK.r_65Lq.~WCOtthZjQnoOJHfbNhjmQ5Ga'; //API SimSimi
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
