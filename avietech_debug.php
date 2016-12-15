<?php

// File Debug
if (!function_exists('fdebug')) {
  function fdebug($message)
  {
    $sRoot = $_SERVER['DOCUMENT_ROOT'];
    $f = fopen($sRoot . '/cividebug.txt', 'a');
    fwrite($f, '############## ' . date(DATE_RFC2822) . "\r\n");
    fwrite($f, $message . "\r\n");
    fwrite($f, "\r\n");
    fwrite($f, "\r\n");
    fclose($f);
  }
}

// Screen Debug
if (!function_exists('sdebug')) {
  function sdebug($formName, &$form) {
    echo '<h1>FORM LOAD: ' . $formName . '</h1>';
    echo "<script>console.log('Form Name: " . $formName . "' );</script>";
    echo "<script>console.log('Form URL: " . $form->_urlPath . "' );</script>";

    $vars = get_object_vars($form);
    echo '<pre>'; 
    print_r($vars); 
    echo '</pre>';
  }
}
// Telegram Debug
if (!function_exists('tdebug')) {
  function tdebug($message)
  {
    $sRoot = $_SERVER['DOCUMENT_ROOT'];
    $f = fopen($sRoot . '/botid.txt', 'r');
    $botid = fgets($f);
    fclose($f);

    $f = fopen($sRoot . '/chatid.txt', 'r');
    $chatid = fgets($f);
    fclose($f);

    $postdata = http_build_query(
    array(
      'chat_id' => $chatid,
      'text' => $message
    )
    );

    $opts = array(
      'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
      )
    );
    $context  = stream_context_create($opts);
    $result = file_get_contents('https://api.telegram.org/' . $botid . '/sendMessage', false, $context);
  }
}
