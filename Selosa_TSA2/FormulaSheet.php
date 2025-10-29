<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Technical 2 Act 2</title>
</head>
<body>

    <h1>Volume of Shapes</h1>

    <table>
        <tr>
            <th>Shape</th>
            <th>Formula</th>
            <th>Values</th>
            <th>Volume</th>
        </tr>

        <?php
        function volumeCube($side) {
            return pow($side, 3);
        }

        function volumeRectangularPrism($length, $width, $height) {
            return $length * $width * $height;
        }

        function volumeCylinder($radius, $height) {
            return pi() * pow($radius, 2) * $height;
        }

        function volumeCone($radius, $height) {
            return (1/3) * pi() * pow($radius, 2) * $height;
        }

        function volumeSphere($radius) {
            return (4/3) * pi() * pow($radius, 3);
        }

        $side = 4;
        $length = 5;
        $width = 3;
        $height = 7;
        $radius = 6;

        echo "<tr>
                <td>Cube</td>
                <td>V = s³</td>
                <td>s = $side</td>
                <td>" . number_format(volumeCube($side), 2) . "</td>
            </tr>";

        echo "<tr>
                <td>Right Rectangular Prism</td>
                <td>V = l × w × h</td>
                <td>l = $length, w = $width, h = $height</td>
                <td>" . number_format(volumeRectangularPrism($length, $width, $height), 2) . "</td>
            </tr>";

        echo "<tr>
                <td>Cylinder</td>
                <td>V = π × r² × h</td>
                <td>r = $radius, h = $height</td>
                <td>" . number_format(volumeCylinder($radius, $height), 2) . "</td>
            </tr>";

        echo "<tr>
                <td>Cone</td>
                <td>V = (1/3) × π × r² × h</td>
                <td>r = $radius, h = $height</td>
                <td>" . number_format(volumeCone($radius, $height), 2) . "</td>
            </tr>";

        echo "<tr>
                <td>Sphere</td>
                <td>V = (4/3) × π × r³</td>
                <td>r = $radius</td>
                <td>" . number_format(volumeSphere($radius), 2) . "</td>
            </tr>";
        ?>
    </table>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f8ff;
        padding: 20px;
    }

    h1 {
        text-align: center;
    }

    table {
        width: 60%;
        margin: auto;
        border-collapse: collapse;
        background: #fff;
    }

    th, td {
        padding: 10px;
        border: 1px solid #333;
        text-align: center;
    }

    th {
        background-color: #add8e6;
    }
</style>