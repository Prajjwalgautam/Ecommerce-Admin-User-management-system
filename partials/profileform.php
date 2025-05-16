<form method="POST" enctype="multipart/form-data" id="profileForm">
    <div class="profile-header">
        <div>
            <?php if (!empty($profile['profile_image'])): ?>
                <img src="<?php echo htmlspecialchars($profile['profile_image']); ?>" alt="Profile Image" class="profile-image">
            <?php else: ?>
                <img src="images/default-profile.jpg" alt="Default Profile" class="profile-image">
            <?php endif; ?>
        </div>
        <div class="profile-info">
            <div class="form-group">
                <label for="profile_image">Change Profile Picture</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" disabled>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="name">First Name</label>
        <input type="text" id="name" name="firstname" value="<?php echo htmlspecialchars($profile['firstname'] ?? ($user['firstname'] ?? '')); ?>" required disabled>
    </div>
    <div class="form-group">
        <label for="name">last Name</label>
        <input type="text" id="name" name="lastname" value="<?php echo htmlspecialchars(($user['lastname'] ?? '')); ?>" required disabled>
    </div>



    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['email'] ?? ($user['email'] ?? '')); ?>" required disabled>
    </div>

    <div class="form-group">
        <label for="number">Phone Number</label>
        <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($profile['number'] ?? ''); ?>" disabled>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>" disabled>
    </div>

    <div class="form-group">
        <label for="country">Country</label>
        <select id="country" name="country" disabled>
            <option value="">Select Country</option>
            <?php
            $countries = ['nepal', 'kathmandu', 'gulmi', 'jhapa', 'ok', 'go', 'Other'];
            foreach ($countries as $country) {
                $selected = (isset($profile['country']) && $profile['country'] == $country) ? 'selected' : '';
                echo "<option value=\"$country\" $selected>$country</option>";
            }
            ?>
        </select>
    </div>
    <button type="button" id="editBtn" class="btn">Edit</button>
    <button type="submit" id="saveBtn" class="btn" disabled>Save Profile</button>
</form>

<script>
    document.getElementById('editBtn').addEventListener('click', function() {
        // Enable all form inputs except the edit button
        const inputs = document.querySelectorAll('#profileForm input, #profileForm select, #profileForm textarea');

        inputs.forEach(input => {
            input.disabled = false;
        });

        // Enable the save button
        document.getElementById('saveBtn').disabled = false;

        // Optionally, you could disable the edit button after clicking it
        this.disabled = true;
    });
</script>