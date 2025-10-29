<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Formative 3 Act 3</title>
</head>
<body>
  <div class="container">
    <h1>Array using User Defined Function</h1>

    <?php
    function calculateOperations($a, $b, $c) {
        $sum = $a + $b + $c;
        $difference = $a - $b - $c;
        $product = $a * $b * $c;

        if ($b != 0 && $c != 0) {
            $quotient = $a / $b / $c;
        } else {
            $quotient = 'Undefined (division by zero)';
        }

        return [
            'sum' => $sum,
            'difference' => $difference,
            'product' => $product,
            'quotient' => $quotient
        ];
    }

    $result = calculateOperations(20, 5, 2);

    echo "<p><strong>Inputs:</strong> 20, 5, 2</p>";
    echo "<p><strong>Sum:</strong> " . $result['sum'] . "</p>";
    echo "<p><strong>Difference:</strong> " . $result['difference'] . "</p>";
    echo "<p><strong>Product:</strong> " . $result['product'] . "</p>";
    echo "<p><strong>Quotient:</strong> " . $result['quotient'] . "</p>";
    ?>
  </div>
</body>
</html>

<style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      padding: 30px;
    }
    .container {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #444;
    }
    p {
      font-size: 18px;
    }
</style>