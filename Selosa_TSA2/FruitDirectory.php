<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Technical 2 Act 1</title>
</head>
<body>
    <h1>Fruit Directory</h1>

    <table border="1" cellspacing="0" cellpadding="10" width="100%">
    <tr>
        <th colspan="4" style="text-align:center;">Fruits ni Denn</th>
    </tr>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Description</th>
        <th>Facts</th>
    </tr>

        <?php
        $fruits = [
        [
            "name" => "Apple",
            "image" => "images/Apple.jpg",
            "description" => "Apples are sweet, crisp fruits commonly red, green, or yellow.",
            "fact" => "Apples float in water because they are 25% air."
        ],
        [
            "name" => "Banana",
            "image" => "images/Banana.jpg",
            "description" => "Bananas are soft, sweet fruits wrapped in a yellow peel.",
            "fact" => "Bananas are technically berries, while strawberries are not."
        ],
        [
            "name" => "Cherry",
            "image" => "images/Cherry.jpg",
            "description" => "Cherries are small, round fruits that can be sweet or tart.",
            "fact" => "Japan's cherry blossoms (sakura) are world famous."
        ],
        [
            "name" => "Durian",
            "image" => "images/Durian.jpg",
            "description" => "Durian is a large, spiky fruit known for its strong smell.",
            "fact" => "It’s banned in many hotels and airports in Southeast Asia."
        ],
        [
            "name" => "Grape",
            "image" => "images/Grape.jpg",
            "description" => "Grapes are juicy fruits that come in clusters and various colors.",
            "fact" => "Grapes are used to make wine, juice, raisins, and vinegar."
        ],
        [
            "name" => "Kiwi",
            "image" => "images/Kiwi.jpg",
            "description" => "Kiwi is a fuzzy brown fruit with bright green flesh and tiny black seeds.",
            "fact" => "Kiwis are rich in Vitamin C—more than oranges."
        ],
        [
            "name" => "Mango",
            "image" => "images/Mango.jpg",
            "description" => "Mangoes are sweet, tropical fruits with golden flesh and a single seed.",
            "fact" => "India is the largest producer of mangoes in the world."
        ],
        [
            "name" => "Orange",
            "image" => "images/Orange.jpg",
            "description" => "Oranges are citrus fruits known for their bright skin and juicy flesh.",
            "fact" => "Oranges are the most cultivated fruit tree in the world."
        ],
        [
            "name" => "Pineapple",
            "image" => "images/Pineapple.jpg",
            "description" => "Pineapples are tropical fruits with rough spiky skin and sweet flesh.",
            "fact" => "It takes almost 2 years for a pineapple to grow"
        ],
        [
            "name" => "Strawberry",
            "image" => "images/Strawberry.jpg",
            "description" => "Strawberries are red, juicy fruits with seeds on the outside.",
            "fact" => "Strawberries are the only fruit with seeds on the outside."
        ],
        [
            "name" => "Lemon",
            "image" => "images/Lemon.jpg",
            "description" => "A tart citrus fruit widely used for flavoring and cleaning.",
            "fact" => "Lemons are rich in vitamin C and aid digestion."
        ],
        [
            "name" => "Papaya",
            "image" => "images/Papaya.jpg",
            "description" => "A tropical fruit with buttery texture and sweet flavor.",
            "fact" => "Papayas aid digestion with an enzyme called papain."
        ],
        [
            "name" => "Watermelon",
            "image" => "images/Watermelon.jpg",
            "description" => "Large, juicy fruit that's perfect for hydration.",
            "fact" => "Watermelon is 92% water and great for hydration."
        ],
        [
            "name" => "Dragon Fruit",
            "image" => "images/Dragonfruit.jpg",
            "description" => "Dragon Fruit has vibrant pink skin and speckled flesh, known for its mildly sweet taste.",
            "fact" => "Also called pitaya, it's a cactus fruit rich in fiber and antioxidants."
        ],
        [
            "name" => "Rambutan",
            "image" => "images/Rambutan.jpg",
            "description" => "Rambutan is a hairy red fruit with juicy, translucent flesh inside.",
            "fact" => "Despite its exotic look, rambutan is closely related to lychee and is rich in vitamin C."
        ],
        [
            "name" => "Atis",
            "image" => "images/Atis.jpg",
            "description" => "Atis is a green, scaly fruit with creamy, sweet white pulp and many seeds.",
            "fact" => "Also called sugar apple, Atis is popular in tropical countries and rich in dietary fiber."
        ],
        [
            "name" => "Jackfruit",
            "image" => "images/Jackfruit.jpg",
            "description" => "Jackfruit is a large tropical fruit with spiky skin and sweet, yellow flesh.",
            "fact" => "Jackfruit is the largest tree-borne fruit and is often used in both desserts and savory dishes in Filipino cuisine."
        ],
        [
            "name" => "Santol",
            "image" => "images/Santol.jpg",
            "description" => "Santol has a thick rind and soft, white pulp that can be sweet or sour.",
            "fact" => "In the Philippines, santol is often enjoyed with salt or bagoong as a sour snack."
        ],
        [
            "name" => "Guyabano",
            "image" => "images/Guyabano.jpg",
            "description" => "Guyabano has spiky green skin and soft white flesh with a sweet and tangy flavor.",
            "fact" => "Guyabano is believed to have medicinal properties and is often used in juices and smoothies."
        ],
        [
            "name" => "Coconut",
            "image" => "images/Coconut.jpg",
            "description" => "Coconut is a tropical fruit with a hard shell, white meat, and refreshing water inside.",
            "fact" => "Every part of the coconut tree is used in Filipino culture—from food and drink to building materials and crafts."
        ]
        ];

        usort($fruits, fn($a, $b) => strcmp($a['name'], $b['name']));

        foreach ($fruits as $fruit) {
        echo "<tr>";
        echo "<td><img src='{$fruit['image']}' alt='{$fruit['name']}' class='fruit-img'></td>";
        echo "<td class='name'>{$fruit['name']}</td>";
        echo "<td class='description'>{$fruit['description']}</td>";
        echo "<td class='fact'>{$fruit['fact']}</td>";
        echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #eef6ff;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: #fff;
    }

    th, td {
        border: 1px solid #000;
        vertical-align: top;
    }

    th {
        background-color: #f2f2f2;
    }

    td.name, td.description, td.fact {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }

    .fruit-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        display: block;
        margin: 0 auto;
    }
</style>