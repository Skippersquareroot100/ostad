<?php
include 'includes/header.php';

$sql = "SELECT * FROM images ORDER BY upload_date DESC";
$stmt = $pdo->query($sql);
$images = $stmt->fetchAll();
?>

<div class="container my-4">
  <h1 class="mb-4">Photo Gallery</h1>
  <div class="row">

    <?php foreach($images as $image) { ?>
      <div class="col-md-4 mb-4">
        <div class="card" style="width: 100%;">
          <img src="assets/images/<?php echo htmlspecialchars($image['filename']); ?>" class="card-img-top" alt="Image">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($image['title']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($image['upload_date']); ?></p>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>
</div>

<?php
include 'includes/footer.php';
?>
