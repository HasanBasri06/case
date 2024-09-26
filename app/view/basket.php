<!DOCTYPE html>
<html lang='tr'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>basket</title>
</head>
<body>
  
<ul>
    <?php foreach($baskets as $basket): ?>
      <li><?= $basket; ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>