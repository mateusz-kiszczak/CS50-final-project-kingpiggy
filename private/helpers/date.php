<?php
function timestampToDate(string $timestamp): string
{
  $current_timestamp = new DateTime($timestamp);
  $converted_timestamp = $current_timestamp->format('jS, F Y');
  return $converted_timestamp;
};

function timestampToDateSlash(string $timestamp): string
{
  $current_timestamp = new DateTime($timestamp);
  $converted_timestamp = $current_timestamp->format('d/m/Y');
  return $converted_timestamp;
};

function timestampToFullTime(string $timestamp): string
{
  $current_timestamp = new DateTime($timestamp);
  $converted_timestamp = $current_timestamp->format('H:i:s');
  return $converted_timestamp;
};


// Conver string to date, output YYYY-MM-DD
function str_to_date($str) {

  // Create a DateTime object from the string
  $date = new DateTime($str);

  // Format the DateTime object as a date
  $formated_date = $date->format("Y-m-d");

  return $formated_date;
}