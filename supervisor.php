<?php
session_start();
include("conn.php");

$sql = "SELECT * FROM properties";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor</title>
    <link rel="stylesheet" href="./assets/css/project.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header>
        <div class="header2">
            <div class="header-left">
                <h2>Our Properties</h2>
            </div>
            <div class="header-right">
                <div class="user-dropdown">
                    <div class="userid">
                        <i class='fa fa-user' class="user-icon"></i>
                        <h5>Role: <?php echo $_SESSION["user_role"]; ?></h5>
                    </div>
                    <div class="dropdown-content">
                        <a><?php echo $_SESSION["user_name"]; ?></a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>



    <section>
        <div class="container">
            <div class="row">
            <?php
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $location = $row['location'];
                            $price = $row['price'];
                            $description = $row['description'];
                            $imagePath = $row['image_path'];
                            
                            ?>
                <div class="col-md-4 col-sm-12">
                    <div class="box">
                        <div class="top">
                            <a href=""><img src="<?php echo $imagePath; ?>" alt="1" /></a>
                        </div>
                        <div class="bottom">
                            <h3><a href=""><?php echo $name; ?></a></h3>
                            <p><?php echo $description; ?></p>
                        </div>
                        <div class="price">
                            <p>For Sale : <span><?php echo $price; ?></span></p>
                            <p>Location : <span><?php echo $location; ?></span></p>
                        </div>
                    </div>
                </div>
                <?php
                        } 
                    } else {
                        echo "No properties found."; 
                    }
                    ?>
            </div>
        </div>
    </section>


   
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>