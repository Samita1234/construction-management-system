<?php
session_start();
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['property_id'])) {
        $property_id = $_POST['property_id'];
        
       
        $name = $_POST['name'];
        $location = $_POST['location'];
        $price = $_POST['price'];
        $description = $_POST['description'];

       
        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
           
            $uploads_directory = 'uploads/';

           
            $new_image_filename = uniqid() . '_' . $_FILES['new_image']['name'];
            $new_image_path = $uploads_directory . $new_image_filename;

           
            if (move_uploaded_file($_FILES['new_image']['tmp_name'], $new_image_path)) {
               
                $sql = "UPDATE properties SET name=?, location=?, price=?, description=?, image_path=? WHERE id=?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                   
                    $stmt->bind_param("ssdssi", $name, $location, $price, $description, $new_image_path, $property_id);

                    if ($stmt->execute()) {
                       
                        $stmt->close();                       
                        
                        header('Location: project_mng-details.php?id='.$property_id); 
                        exit();
                    } else {
                        echo "Error executing query: " . $stmt->error;
                        $stmt->close();
                    }
                } else {
                    echo "Error preparing query: " . $conn->error;
                }
            } else {
                echo "Error uploading the image.";
            }
        } else {
           
            $sql = "UPDATE properties SET name=?, location=?, price=?, description=? WHERE id=?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssdsi", $name, $location, $price, $description, $property_id);

                if ($stmt->execute()) {
                    $stmt->close();
                    header('Location: project_mng-details.php?id='.$property_id); 
                    exit();
                } else {
                    echo "Error executing query: " . $stmt->error;
                    $stmt->close();
                }
            } else {
                echo "Error preparing query: " . $conn->error;
            }
        }
    } else {
        echo "Property ID is missing in the POST data.";
    }
}

mysqli_close($conn);

include("conn.php");

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    $sql = "SELECT * FROM properties WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $property_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $location = $row['location'];
                $price = $row['price'];
                $description = $row['description'];
                $imagePath = $row['image_path'];
            } else {
                echo "Property not found.";
            }
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }
} else {
    echo "Property ID not provided.";
}

$conn->close();


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="./assets/css/project.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
    <section class="properties">
        <div class="container">
            <div class="row">
                <div class="col-md-12 heading">
                    <h3><?php echo $name; ?></h3>
                </div>
                <div class="p-3 col-md-6 col-sm-12">
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo $name; ?>" style="width:100%"/>
                    <button type="button" data-bs-toggle="modal" ><a href="project_mng.php">Back To Property List</a></button>
                </div>
                <div class="p-3 col-md-6 col-sm-12">
                    <h6>Price : <span>Rs.<?php echo $price; ?></span></h6>
                    <h6>location : <span><?php echo $location; ?></span></h6>
                    <div class="about">
                        <h6>About This Property :</h6>
                        <p><?php echo $description; ?></p>
                        <div class="buttons">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#myModa2" style="background:blue">Edit Property</button>
                            <form action="delete.php" method="POST">
                                <button type="submit" name="delete" value="<?= $row['id'];?>" style="background:red">Delete Property</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="myModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Property</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="bg-body-tertiary" enctype="multipart/form-data" method="POST" action="project_mng-details.php">
                        <input type="hidden" name="property_id" value="<?php echo $property_id; ?>" />
                        <div class="form-floating mb-3">
                            <input type="text" id="form4Example1" name="name" value="<?php echo $name; ?>" class="form-control" />
                            <label class="form-label" for="form4Example1">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <img src="<?php echo $imagePath; ?>" alt="Current Image" class="img-fluid" />
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" id="form4Example2" name="new_image" accept="image/*" class="form-control" />
                            <label class="form-label" for="form4Example2">New Picture</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="form4Example3" name="location" value="<?php echo $location; ?>" class="form-control" />
                            <label class="form-label" for="form4Example3">Location</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" id="form4Example4" name="price" value="<?php echo $price; ?>" class="form-control" />
                            <label class="form-label" for="form4Example4">Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="form4Example5" name="description" rows="4"><?php echo $description; ?></textarea>
                            <label class="form-label" for="form4Example5">Description</label>
                        </div>
                        <button type="submit" class="w-100 btn btn-lg btn-primary">Update Property</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>



