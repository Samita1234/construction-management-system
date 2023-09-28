<?php
session_start();
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['name'];
    $description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];

        $uploads_directory = 'uploads/';
        $target_path = $uploads_directory . $file_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
        } else {
            echo "Error uploading file.";
        }
    }

    if ($conn) {
        $sql = "INSERT INTO construction_sheets (title, description, path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $title, $description , $target_path);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();

                header('Location: contractor.php');
                exit();
            } else {
                echo "Error executing query: " . $stmt->error;
                $stmt->close();
                $conn->close();
            }
        } else {
            echo "Error preparing query: " . $conn->error;
            $conn->close();
        }
    } else {
        echo "Database connection failed: " . mysqli_connect_error();
    }
}

$sql = "SELECT * FROM construction_sheets";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contractor</title>
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
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="top col-md-12">
                    <button><a type="button" data-bs-toggle="modal" data-bs-target="#myModal3">Upload Sheets</a></button>
                </div>
                <?php
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $imagePath = $row['path'];
                            ?>
                <div class="p-3 col-xl-6 col-md-6 col-sm-12">
                    <div class=" card-1">
                        <img src="<?php echo $imagePath; ?>" alt="1">
                        <div class="text">
                            <h5><?php echo $title; ?></h5>
                        </div>
                        <div class="describe">
                            <p><?php echo $description; ?></p>
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

<div class="modal fade" id="myModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add New Construction Sheets </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="bg-body-tertiary" enctype="multipart/form-data" method="POST" action="contractor.php">
                        <div class="form-floating mb-3">
                            <input type="text" id="form4Example1" name="name" placeholder="Name" class="form-control" />
                            <label class="form-label" for="form4Example1">Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" id="form4Example2" name="image" accept="image/*" class="form-control" />
                            <label class="form-labe2" for="form4Example2">Picture</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="form4Example5" name="description" rows="4" placeholder="Description"></textarea>
                            <label class="form-labe5" for="form4Example5">Description</label>
                        </div>
                        <button type="submit" class="w-100 btn btn-lg btn-primary">Add Sheets</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>