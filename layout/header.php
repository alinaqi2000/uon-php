<!doctype html>
<html>

<head>
    <title><?= $title ?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="electronics.css" />
</head>

<body>
    <header>
        <h1>Ed's Electronics</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php $categories = getCategories(); ?>
            <li>Products
                <ul>
                    <?php foreach ($categories as $category) : ?>
                        <li><a href="products.php?category=<?= $category['category_id'] ?>"><?= $category['category_name'] ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </li>

        </ul>

        <address>
            <p>We are open 9-5, 7 days a week. Call us on
                <strong>01604 11111</strong>
            </p>
        </address>



    </header>