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

  $words = tokenize($string);
  $result_arr = array();
  $current_line = '';

  foreach ($words as $word) {
    if (strlen($current_line . $word) <= $length) {
      // the next word fits and doesn't overflow
      $current_line .= $word;
    } else {
      // unload the current line, but trim the extraneous space in the end
      if (rtrim($current_line)) {
        $result_arr []= rtrim($current_line);
      }

      if (strlen($word) < $length) {
        $current_line = trim($word); // and move on to the next word
      } else {
        // long string, exceeds the length
        $chunks = str_split($word, $length);

        // unload everything, except the very last chunk - it could be too short
        for ($x = 0; $x < (count($chunks) - 1); $x++) {
          if (rtrim($chunks[$x])) {
            $result_arr []= rtrim($chunks[$x]);
          }
        }
        $current_line = $chunks[count($chunks) - 1]; // let the next iteration of foreach figure it out
      }
    }
  }

  if (rtrim($current_line)) { // we have something left over, and it's not space
    $result_arr []= rtrim($current_line);
  }

  return implode("\n", $result_arr);
}


function tokenize ($str) {
  $result = array();
  $result_index = 0;
  $current_word = '';

  for ($x = 0; $x < strlen($str); $x++) {
    if (!$current_word) {
      // we don't have anything, it's a brand new word
      $current_word .= $str[$x];
    } else {
      $current_word_is_spaces = is_a_space($current_word[0]);
      if (
          ($current_word_is_spaces && is_a_space($str[$x])) ||
          (!$current_word_is_spaces && !is_a_space($str[$x]))
        ) {
        // the easy part, append and move on
        $current_word .= $str[$x];
      } else {
        // we either were collecting spaces and hit a word without them
        // or vice versa
        $result[] = $current_word;
        $current_word = $str[$x];
      }
    }
  }
  // the for loop has ended, load whatever the remains onto the result
  if ($current_word) {
    $result[] = $current_word;
    $current_word = '';
  }

  return $result;
}

// the purpose of separating this into a function is to allow future modifications
// to the definition of space without going around the code and changing
// if() conditions elsewhere

function is_a_space ($c) {
  return $c == ' ' || $c == '\t';
}


function wrap_testNormal($length) {
 print wrap("one two three four five six seven eight nine ten eleven twelve thirteen fourteeen fifteen", $length);
}

function wrap_testVeryLong() {
  print wrap("qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnm", 3);
}

function wrap_testEmpty() {
  print wrap('', 3); // output should be empty string
  print wrap('abcdef', 0); // output should be the original string
}

function wrap_testBreakLongAndWrap() {
  // a long word followed by a short word - the long word would be broken, but
  // the short word should stay appended
  print wrap('abcdef a abcdef b abcdef c', 5);
}

function wrap_testDuplets(){
  print wrap('ab cd ef gh ij kl', 5);
}


//wrap_testEmpty();
//wrap_testNormal(3);
//wrap_testNormal(5);
// wrap_testNormal(10);
// wrap_testNormal(15);
// wrap_testVeryLong();
//wrap_testBreakLongAndWrap();
//wrap_testDuplets();
