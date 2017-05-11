<?php

function wrap ($string, $length) {
  // egde case - empty string
  if (strlen($string) < 1) {
    return '';
  }

  // edge case - no length
  if ($length < 1) {
    return $string;
  }

  // Pass 1: split on *any* whitespace character
  $words =  preg_split("/[\s,]+/", $string);

  // Pass 2: break down any words longer than $length
  $words2 = array();

  foreach ($word in $words) {
    $word = trim($word);
    if (strlen($word) < 1) {
      // this was an empty whitespace character that got trimmed out
      next;
    }
    if (strlen($word) > $length) {
      // break this long word into an array of its own
      $chunks = str_split($word, $length);
      // just append to a larger array
      $words2 = array_merge($words2, $chunks);
    } else {
      // just a normal sub-length word
      $words2[] = $word;
    }
  }

  $result = implode("\n", $words2);
  return $result;
}
