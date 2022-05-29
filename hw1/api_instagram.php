<?php
  $code = 'AQDbZHOYSJpP-eViOLekRfSqeR45opGXSYQ1EBgxUwW2WeeOeDxpz659ZY0FQ4lxeKiuRK7-N8XSFa49ieb7KOaHviV5vOMfQYHgLZUzeH7HdwN--FjmCx_Bz9ejySll0IkFptNc2uIfM1LZR4zcsAYia4NdrrEOIeqg-1qO8HM5P7_x35gYZKKthebssh0mm5Equ8sLgaaeEkmQpH6mKPc254uh5d-N8TAnhPCNuGub_Q';
  $endpoint = 'https://api.instagram.com/oauth/access_token';
  $secret_c = 'd3bbe5ccf4385bc0d7aa1a61b8042890';
  $id_c = '525413989187648';
  $redirect_url = 'https://www.racing.stewielab.it/';
  $endpoint_media = 'https://graph.instagram.com/me/';
  $access_tk;

  $dati = array("client_id" => $id_c, "client_secret" => $secret_c, "grant_type"=>"authorization_code", "redirect_uri"=> $redirect_url, "code"=>$code);
  $dati = http_build_query($dati);
  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, $endpoint);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $dati);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec($curl);
  $access_tk= json_decode($result)->access_token;
  curl_close($curl);

  $curl2 = curl_init();
  curl_setopt($curl2, CURLOPT_URL,
  $endpoint_media."media?fields=media_type,media_url&access_token=".$access_tk);
  curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
  $json = json_decode(curl_exec($curl2))->data;
  curl_close($curl2);
  $content_array=[];
  $i=0;
  foreach($json as $content){
      $content_array[$i]['media_type']=$content->media_type;

      $content_array[$i]['media_url']=$content->media_url;


      $i++;
  }
  echo json_encode($content_array);
?>
