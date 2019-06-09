<?php
$finalDir = "C:\\xampp\\htdocs\\ExpWebsite\\uploads";
$name = $_FILES['myfile']['name'];


# Go to all lower case for consistency
$name = strtolower($name);
# Only these extensions will be allowed
$safeExtensions = array(
    '.html',
    '.htm',
    '.gif',
    '.jpg',
    '.jpeg',
    '.png',
    '.txt',
    '.pdf'
  );  

preg_match('/^(.*?)(\.\w+)?$/', $name, $matches);

# $matches[0] gets the entire string.
# $matches[1] gets the first sub-expression in (),
# $matches[2] the second, etc.

$stem = $matches[1];
$extension = isset($matches[2]) ? $matches[2] : '';

# Convert whitespace of any kind to single underscores
$stem = preg_replace('/\s+/', '_', $stem);   

# Remove any remaining characters other than A-Z, a-z, 0-9 and _
$stem = preg_replace('/[^\w]/', '', $stem);

# Make sure the file extension has no odd characters
if (($extension != '') &&
  (!preg_match('/^\.\w+$/', $extension)))
{
  die("Bad file extension");
}

if (!in_array($extension, $safeExtensions)) {
    die("File extension not approved");
  }

# Search for a unique filename by adding a number to the
# stem (first we try without, of course)
$suffix = '';
while (file_exists("$finalDir/$stem$suffix$extension")) {
  if ($suffix == '') {
    $suffix = '0';
  } else {
    $suffix++;
  }    
}  

# Put the full name back together
$name = "$stem$suffix$extension";




echo(move_uploaded_file($_FILES['myfile']['tmp_name'], "$finalDir\\$name"));
echo("\n\n".$finalDir.$name);
?>