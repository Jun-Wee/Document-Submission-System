<!DOCTYPE HTML>
 <html lang="en">
 <head>
  <meta charset="utf-8" />
  <meta name="description" content="title input for web search" />
  <meta name="keywords" content="PHP"/>
  <meta name="author" content="Sandali Jayasinghe" />
  <title>Title Input</title>
 </head>
 <body>
<form name="myForm" action="websearch.php" onsubmit="return validateForm()" method="post">
Title: <input type="text" name="title">
<input type="submit" value="Search">
</form>
</body>
</html>