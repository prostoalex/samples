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
  while (count($words2)) {
    $words3 []= return_at_most($words2, $length);
  } //end of while

  $result = implode("\n", $words3)."\n"; // trailing newline
  return $result;
}

function return_at_most (&$string_arr, $max_length) {
    $current = '';
    $next = '';

    $current = array_shift($string_arr);

    while ($next = array_shift($string_arr)) {
      if (strlen ($current . " " . $next) <= $max_length ) {
        $current .= ' ' . $next;
      } else {
        // we're here because the length of the combined entity exceeds max_length
        array_unshift($string_arr, $next);
        return $current;
      }
    }

    // we're here because there are no more elements left in $string_arr
    return $current;
}

function wrap_testNormal($length) {
 print wrap("one two three four five six seven eight nine ten eleven twelve thirteen fourteeen fifteen", $length);
}

function wrap_testVeryLong() {
  print wrap("qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnm", 3);
}

function wrap_testEmpty() {
  print wrap('', 3);
  print wrap('abcdef', 0);
}

function wrap_testBreakLongAndWrap() {
  // a long word followed by a short word - the long word would be broken, but
  // the short word should stay appended
  print wrap('abcdef a abcdef b abcdef c', 5);
}

function wrap_testDuplets(){
  print wrap('ab cd ef gh ij kl', 5);
}


wrap_testEmpty();
wrap_testNormal(3);
wrap_testNormal(5);
wrap_testNormal(10);
wrap_testNormal(15);
wrap_testVeryLong();
wrap_testBreakLongAndWrap();
wrap_testDuplets();
