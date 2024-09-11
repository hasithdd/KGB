<?php
function loadEnv($path = '.env')
{
  $path = '../'.$path;
  if (!file_exists($path)) {
    throw new \Exception($path . ' file not found.');
  }

  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  foreach ($lines as $line) {
    // Skip comments
    if (strpos(trim($line), '#') === 0) {
      continue;
    }

    // Split into key and value
    list($key, $value) = explode('=', $line, 2);

    // Remove whitespace
    $key = trim($key);
    $value = trim($value);

    // Set environment variable
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
  }
}