<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Formative 3 Act 2</title>
</head>
<body>
  <div class="container">
    <h1>Array Calculator</h1>

    <?php
    $numbers = [12, 5, 3, 8, 2, 10, 6, 4, 9, 7];

    $sum = 0;
    $difference = $numbers[0];
    $product = 1;
    $quotient = $numbers[0];

    for ($i = 0; $i < count($numbers); $i++) {
        $sum += $numbers[$i];
        $product *= $numbers[$i];
        if ($i > 0) {
            $difference -= $numbers[$i];
            if ($numbers[$i] != 0) {
                $quotient /= $numbers[$i];
            } else {
                $quotient = 'Undefined (division by zero)';
                break;
            }
        }
    }

    echo "<p><strong>Numbers:</strong> " . implode(', ', $numbers) . "</p>";
    echo "<p><strong>Sum:</strong> $sum</p>";
    echo "<p><strong>Difference:</strong> $difference</p>";
    echo "<p><strong>Product:</strong> $product</p>";
    echo "<p><strong>Quotient:</strong> $quotient</p>";
    ?>
  </div>
</body>
</html>

<style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      padding: 30px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #333;
    }
    p {
      font-size: 18px;
    }
</style>