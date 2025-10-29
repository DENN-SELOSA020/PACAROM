<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Formative 3 Activity 1</title>
</head>
<body>
    <h1>Legend of Zelda: Breath of the Wild</h1>

    <?php

    $people = [
        ['name' => 'Link',            'image' => 'Link.png',       'age' => 117,  'birthday' => '1907-10-20', 'contact' => '09171234567'],
        ['name' => 'Princess Zelda',  'image' => 'Princess_Zelda.png', 'age' => 117,  'birthday' => '1907-06-10', 'contact' => '09181234567'],
        ['name' => 'Ganondorf',       'image' => 'Ganondorf.png',  'age' => 1000, 'birthday' => '1025-12-01', 'contact' => '09191234567'],
        ['name' => 'Mipha',           'image' => 'Mipha.png',      'age' => 121,  'birthday' => '1904-02-14', 'contact' => '09051234567'],
        ['name' => 'Daruk',           'image' => 'Daruk.png',      'age' => 122,  'birthday' => '1903-08-18', 'contact' => '09102234567'],
        ['name' => 'Urbosa',          'image' => 'Urbosa.png',     'age' => 123,  'birthday' => '1902-11-05', 'contact' => '09331234567'],
        ['name' => 'Revali',          'image' => 'Revali.png',     'age' => 120,  'birthday' => '1905-04-09', 'contact' => '09551234567'],
        ['name' => 'Impa',            'image' => 'Impa.png',           'age' => 132,  'birthday' => '1893-01-30', 'contact' => '09771234567'],
        ['name' => 'Korok',           'image' => 'Korok.png',      'age' => 200,  'birthday' => '1825-09-09', 'contact' => '09991234567'],
        ['name' => 'King Rhoam',      'image' => 'King_Rhoam.png', 'age' => 145,  'birthday' => '1880-07-17', 'contact' => '09611234567'],
    ];

    function compareNames($a, $b) {
    if ($a['name'] == $b['name']) return 0;
    return ($a['name'] < $b['name']) ? -1 : 1;
    }

    usort($people, 'compareNames');
    ?>

    <table>
    <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Image</th>
        <th>Age</th>
        <th>Birthday</th>
        <th>Contact Number</th>
    </tr>
    <?php
    $no = 1;
    foreach ($people as $person):
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $person['name'] ?></td>
        <td><img src="images/<?= $person['image'] ?>" alt="<?= $person['name'] ?>"></td>
        <td><?= $person['age'] ?></td>
        <td><?= $person['birthday'] ?></td>
        <td><?= $person['contact'] ?></td>
    </tr>
    <?php endforeach; ?>
    </table>

</body>
</html>

<style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    table {
      margin: auto;
      border-collapse: collapse;
      width: 90%;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #ccc;
    }

    th {
      background: #0077cc;
      color: white;
    }

    img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
    }

    tr:hover {
      background-color: #f1f1f1;
    }
</style>