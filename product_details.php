<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attire Home</title>
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link rel = "stylesheet" href = "bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel = "stylesheet" href = "css/main.css">
    <!-- Add Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<style>
    
/* img{
    height: 100px;
} */

.image_slide{
    height:500px;
    width: 500px;
}
.swiper-container {
    width: 100px;
    height: 100px;
  }
  
  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .swiper-slide img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }

  
.slider{
    position: relative;
     max-width: 40rem; 
    height: 26.625rem; 
    margin: 0 auto;
    overflow: hidden;
}
.slide{ 
    position: absolute;
    top:0;
    width: 100%;
    height: 26.625rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 1s;
}
.slide > img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
button{
    background:none;
    border: none;
    color: rgba(31, 28, 28, 0.5);
}
button .fas{
    color: rgba(31, 28, 28, 0.5);
}
.btn-slide{
    position:absolute;
    top:50%;
    z-index: 10;

    height: 5.5rem;
    width: 5.5rem;
    cursor: pointer;
}
.prev{
    left:3rem;
    transform: translate(-50%, -50%);
}
.next{
    right: 3rem;
    transform: translate(50%, -50%); 
}
.dots-container{
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}
.dot{
    width: 25px;
    height: 5px;
    margin: 15px 5px;
    border-radius: .5rem;
    background: rgba(39,39,39, .5);
    cursor: pointer;
}
.dot.active{
background:#272727;
}
.product_container{
    margin-top:10vw;
}
  
</style>
</head>
<!-- <body> -->
    
    <!-- navbar -->
    <?php
// Include the navigation bar
include 'nav.php';
?>
<body>

<!-- <div class="list-container">
    <div class="images">
        <img src="images/full.png">
    </div>
    <div class="product-desc">
        <div class="product-title"><h2>ZBR TOP</h2></div>
        
        <div class="small-desc">
        sdfghjksdfhg skjdfghk hkgsjfdhg kjh k
        </div>
    </div>
</div> -->
<!--  -->








<div class="list-container">
<div class="images">
    <div class="slider">
    <?php
// Your database connection code goes here
require_once 'db_connect.php';
// Retrieve the product ID from the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve the product images from the database
    $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result) {
        // Check if the product has images
        if ($result->num_rows > 0) {
            // Fetch the image paths from the result
            $row = $result->fetch_assoc();
            $imagePaths = explode(',', $row['image_paths']);

            // Loop through the image paths and display them
            foreach ($imagePaths as $index => $imagePath) {
                echo '<div class="slide">';
                echo '<img src="' . $imagePath . '" alt="Product Image">';
                echo '</div>';
                echo '<span class="dot' . ($index == 0 ? ' active' : '') . '" data-slide="' . $index . '"></span>';
            }
            
            echo '<button class="btn-slide prev"><i class="fas fa-3x fa-chevron-circle-left"></i></button>';
            echo '<button class="btn-slide next"><i class="fas fa-3x fa-chevron-circle-right"></i></button>';
            
            echo '</div>';
            
            echo '<div class="dots-container">';
            foreach ($imagePaths as $index => $imagePath) {
                echo '<span class="dot active' . ($index == 0 ? ' active' : '') . '" data-slide="' . $index . '"></span>';
            }
            echo '</div>';
            echo '<form action="add_to_cart.php" method="post">';
echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
echo '<button type="submit" class="btn-add-to-cart">Add to Cart</button>';
echo '</form>';
            echo '</div>';




            echo '<div class="product-desc">';
            echo '<div class="product-title">'.$row['product_name'].'</div>';
            echo '<div class="product-price">Rs.'.$row['price'].'</div>';
            echo '<div class="small-desc">';
            echo $row['description'];
            echo '</div>';
            echo '</div>';
            




        } else {
            // No images found for the product
            echo "No images found for the product.";
        }
    } else {
        // Query execution failed
        echo "Error executing query: " . $conn->error;
    }
} else {
    // Product ID is not provided in the URL
    echo "Product ID is missing.";
}

// Close the database connection
$conn->close();
?>

 



</div>
<!-- 

        <button class="btn-slide prev"><i class="fas fa-3x fa-chevron-circle-left"></i></button>
        <button class="btn-slide next"><i class="fas fa-3x fa-chevron-circle-right"></i></button>
      
    </div> -->
    <!-- <div class="dots-container">
            <span class="dot active" data-slide="0"></span>
            <span class="dot" data-slide="1"></span>
            <span class="dot" data-slide="2"></span>
      <span class="dot" data-slide="3"></span>
    </div> -->













<script>
    function Slider() {
    const carouselSlides = document.querySelectorAll('.slide');
    const btnPrev = document.querySelector('.prev');
    const btnNext = document.querySelector('.next');
    const dotsSlide = document.querySelector('.dots-container');
    let currentSlide = 0;
  
    const activeDot = function (slide) {
        document.querySelectorAll('.dot').forEach(dot => dot.classList.remove('active'));
        document.querySelector(`.dot[data-slide="${slide}"]`).classList.add('active');
    };
    activeDot(currentSlide);

    const changeSlide = function (slides) {
        carouselSlides.forEach((slide, index) => (slide.style.transform = `translateX(${100 * (index - slides)}%)`));
    };
    changeSlide(currentSlide);

    btnNext.addEventListener('click', function () {
        currentSlide++; 
        if (carouselSlides.length - 1 < currentSlide) {
            currentSlide = 0;
        };
        changeSlide(currentSlide);
        activeDot(currentSlide);
});
    btnPrev.addEventListener('click', function () {
        currentSlide--;
        if (0 >= currentSlide) {
            currentSlide = 0;
        }; 
        changeSlide(currentSlide);
        activeDot(currentSlide);
    });

    dotsSlide.addEventListener('click', function (e) {
        if (e.target.classList.contains('dot')) {
            const slide = e.target.dataset.slide;
            changeSlide(slide);
            activeDot(slide);
        }
    });
  };
Slider();
</script>



<!-- Add the following JavaScript code for the image slider -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.8.1/slick.min.js"></script>
<script>
$(document).ready(function() {
    $('.slider').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000
    });
});
</script>





