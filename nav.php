<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booklin</title>
<link href="navbar.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  
</head>
<body>
    <header>
<h2 class="logo"><i class="fa-solid fa-house-user"></i>Booklin</h2>
<nav class="navbar">
    <a href="home.php">Home</a>
    <a href="buy.php">Buy</a>
    <a href="selluser.php">Sell</a>
    <a href="cart.php"><i class="fa-solid fa-cart-plus"></i></a>
   <a href="inbox.php"><i class="fa-solid fa-comment"></i></a>
    <a href="account.php">Account</a>

<form method="get" action="/booklin/opfn/searchuser.php" class="srccontainer">
       
        
        <input class="srcbr" type="text" placeholder="Search here" name="searchdata" />
        <input type="submit" value="search" name="searchdataproduct">
    
</form>
   
     <a href="opfn/logout.php">Logout</a>

    
  </nav>  
</header>
</body>
</html>
