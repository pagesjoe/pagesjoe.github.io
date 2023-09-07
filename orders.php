<?php 
    session_start();
    
    // echo $_SESSION['loggedin';
    if(isset($_SESSION['loggedin'])){
        // Get the orders from the database
        $link = mysqli_connect('localhost','root','','nespressodb');
        // $query = "Select id, date, price From orders Where userid = $_SESSION['userid']";
        $userId = $_SESSION['userid'];
        $orders = mysqli_query($link,"SELECT id, date, price From orders Where userid = $userId");
    }else{
        header("location:index.php");
        exit;
    }
    

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="orders.css">
        <title>Document</title>
    </head>
    <body>
        <?php
            // Looping on the orders one by one
            while($order = mysqli_fetch_assoc($orders)){
                $orderId = $order['id'];
                $orderTotal = $order['price'];
                $orderDate = $order['date'];
        ?>

                <!-- Order Div -->
                <div class="order">
                    <div class="order-details">
                        <div class="order-date">
                            <p>Order Date</p>
                            <p><?php echo $orderDate?></p>
                        </div>
                        <p>TOTAL</p>

                        <p>Oder#</p>
                    </div>

                    <!-- Product Div -->
                    <div class="products">
                            <?php
                                // Get the products purchased for this order from database
                                $query = "SELECT product.name, product.image FROM orders, product_purchase, product
                                WHERE orders.id = product_purchase.orderid
                                AND product_purchase.productid = product.id
                                AND orders.id=$orderId";
                                $products = mysqli_query($link,$query);
                                // Looping on each product purchased
                                while($product = mysqli_fetch_assoc($products)){
                                    $image = $product['image'];                                    
                                    $name = $product['name'];
                            ?>
                                    <!-- Product details -->
                                    <div class="product">
                                    <img src="images/<?php echo $image ?>" alt="">
                                        <p><?php echo $name ?></p>
                                    </div>
                            <?php
                                }
                            ?>
                    </div>
                </div>
            <?php
            }
            ?>
    </body>
    </html>