<?php

function wrap ($string, $length) {
  // egde case - empty string
  if (strlen($string) < 1) {
    return $string;
  }

  // edge case - no length
  if ($length < 1) {
    return $string;
  }

  // Pass 1: split on *any* whitespace character
  $words =  preg_split("/[\s]+/", $string);

  // Pass 2: break down any words longer than $length
  $words2 = array();

  foreach ($words as $word) {
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

  // Pass 3: combine the $words2 into lines of appropriate length
  $words3 = array();
  $x = 0;

  while ($x < count($words2)) {
    $current_word = $words2[$x];

    if (($x + 1) < count($words2)) {
      $next_word = $words2[$x+1];
      if (strlen($current_word . " " . $next_word . "\n") < $length) {
        // we can fit the next word and then have some space left over
        $current_word .= " ";
        $current_word .= $next_word;
        $x++;
        continue;
      }
    }

    // We're here because we're  either at a word that's too long
    // or at the last element of the array, and need to move on
    $words3 []= $current_word;
    $x++;
  } //end of while

  $result = implode("\n", $words3)."\n";
  return $result;
}

function wrap_testNormal($length) {
 print wrap("Hello there, how are you, this is a normal test with words of various lengths", $length);
}

function wrap_testVeryLong() {
  print wrap("qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnm", 3);
}

function wrap_testEmpty() {
  print wrap('', 3);
  print wrap('abcdef', 0);
}

wrap_testEmpty();
wrap_testNormal(3);
wrap_testNormal(5);
wrap_testNormal(10);
wrap_testNormal(15);
wrap_testVeryLong();
