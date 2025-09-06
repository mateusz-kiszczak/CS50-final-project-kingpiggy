<?php

function get_client_ip() {
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_REAL_IP']))
      $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
  else if(isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function sanitize_ip_address($ip_address) {
  $sanitized_ip = filter_var($ip_address, FILTER_VALIDATE_IP);

  // If the IP address is valid, return it; otherwise, return a default value or handle the error appropriately
  return $sanitized_ip ? $sanitized_ip : 'Invalid IP Address';
}
