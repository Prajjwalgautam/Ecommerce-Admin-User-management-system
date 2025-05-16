   <?php
    include("partials/database.php");

    $error = '';
    $success = '';
    $show_modal = false;

    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $show_modal = true;


        if (empty($_POST['catalog_name'])) {
            $error = 'Catalog name is required.';
        } elseif (!isset($_POST['stock']) || !is_numeric($_POST['stock'])) {
            $error = 'Invalid stock quantity.';
        } elseif (!isset($_POST['price']) || !is_numeric($_POST['price'])) {
            $error = 'Invalid price quantity.';
        } elseif (!isset($_POST['description']) || !is_numeric($_POST['description'])) {
            $error = 'Invalid price quantity.';
        } elseif (!isset($_FILES['image_path']) || $_FILES['image_path']['error'] !== UPLOAD_ERR_OK) {
            $error = 'Image upload failed.';
        } else {
            // Process the form
            $catalog_name = mysqli_real_escape_string($conn, $_POST['catalog_name']);
            $stock = (int) $_POST['stock'];

            // File upload handling
            $upload_dir = "images/";
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file = $_FILES['image_path'];

            if (!in_array($file['type'], $allowed_types)) {
                $error = 'Only JPG, PNG, and GIF images are allowed.';
            } else {
                // Create upload directory if it doesn't exist
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Generate unique filename
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $target_file = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $target_file)) {
                    // Insert into database
                    $sql = "INSERT INTO catelog (catalog_name, image_path, stock ,price ,description, last_updated) VALUES (?, ?, ?,? ,NOW())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $catalog_name, $target_file, $stock, $price, $description);

                    if ($stmt->execute()) {
                        $success = 'Catalog item added successfully!';
                        $show_modal = false; // Close modal on success
                        // Clear form on success
                        $_POST = array();
                    } else {
                        $error = 'Database error: ' . $stmt->error;
                        // Clean up uploaded file if DB insert failed
                        if (file_exists($target_file)) {
                            unlink($target_file);
                        }
                    }
                    $stmt->close();
                } else {
                    $error = 'Failed to move uploaded file.';
                }
            }
        }
        $conn->close();
    }
    ?>


   <div class="container mt-5">
       <button class="btn btn-primary mb-3" onclick="document.getElementById('addCatalogModal').style.display='block'">
           <i class="fas fa-plus"></i> Add Catalog Item
       </button>

       <?php if ($error): ?>
           <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
       <?php endif; ?>

       <?php if ($success): ?>
           <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
       <?php endif; ?>

       <!-- Modal for Adding Catalog -->
       <div id="addCatalogModal" class="modal">
           <div class="modal-dialog modal-lg">
               <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" class="modal-content">
                   <div class="modal-header bg-primary text-white">
                       <h5 class="modal-title">Add New Catalog Item</h5>
                       <button type="button" class="close" onclick="window.location.href='index.php'" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="catalogName">Catalog Name *</label>
                                   <input type="text" class="form-control" id="catalogName" name="catalog_name" value="<?php echo isset($_POST['catalog_name']) ? htmlspecialchars($_POST['catalog_name']) : ''; ?>" required>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="stock">Stock Quantity *</label>
                                   <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : ''; ?>" required>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="stock">price</label>
                                   <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                               </div>
                           </div>

                       </div>
                       <div class="form-group">
                           <label for="imagePath">Image Upload *</label>
                           <input type="file" class="form-control-file" id="imagePath" name="image_path" accept="image/jpeg,image/png,image/gif" required>
                           <small class="form-text text-muted">Only JPG, PNG, or GIF files up to 5MB are allowed.</small>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" onclick="document.getElementById('addCatalogModal').style.display='none'">Cancel</button>
                       <button type="submit" class="btn btn-primary">
                           <i class="fas fa-save"></i> Save Item
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>

   <script>
       // Simple modal control
       window.onclick = function(event) {
           const modal = document.getElementById('addCatalogModal');
           if (event.target == modal) {
               modal.style.display = "none";
           }
       }
   </script>