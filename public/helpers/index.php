<?php

function convertImage($var1)
{
      $imageData = file_get_contents($var1);
      $base64 = base64_encode($imageData);
      $var2 = "data:image/png;base64," . $base64;
      return $var2;
}

function formatDate($dateString)
{
      [$year, $month, $day] = explode('-', $dateString);
      return ($day . '-' . $month . '-' . $year);
}