<?php
include 'includes/header.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    if (empty($title) || empty($description) || empty($image['name'])) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        $target_dir = "assets/images/"; 
        $file = $image['name'];
        $new_name = uniqid() . '_' . $file;
        $target_file = $target_dir . $new_name;

        if ($image['size'] > 5000000) {
            echo "<div class='alert alert-danger'>File size is too large (max 5MB).</div>";
        } else {
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                $sql = "INSERT INTO images (title, description, filename) VALUES (:title, :description, :image)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description,
                    ':image' => $new_name
                ]);
                echo "<div class='alert alert-success'>Image uploaded successfully!</div>";

                $title = "";
                $description = "";
            } else {
                echo "<div class='alert alert-danger'>Failed to upload file.</div>";
            }
        }
    }
}
?>

<div class="container my-4">
    <h1 class="mb-4">Photo Gallery</h1>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" value="<?php echo isset($description) ? htmlspecialchars($description) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">UPLOAD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
