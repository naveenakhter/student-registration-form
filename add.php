<?php
include 'config.php';

if (isset($_POST['submit'])) {
    // Sanitize inputs (basic)
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $course = htmlspecialchars(trim($_POST['course']));
    $contact = htmlspecialchars(trim($_POST['contact']));

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        $path = "uploads/" . $image;

        // Move uploaded file
        if (move_uploaded_file($tmp_name, $path)) {
            $sql = "INSERT INTO students (name, email, course, contact, image) 
                    VALUES ('$name', '$email', '$course', '$contact', '$image')";

            if ($conn->query($sql) === TRUE) {
                header('Location: view.php');
                exit();
            } else {
                $error = "Database error: " . $conn->error;
            }
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        $error = "Please select an image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register Student</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            margin: 0;
            background: linear-gradient(135deg, #ff3399, #ff66b2);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 8px 30px rgba(255, 51, 153, 0.4);
            text-align: center;
            position: relative;
        }

        h2 {
            margin-bottom: 30px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-shadow: 0 0 8px #fff;
        }

        /* Error box */
        .error {
            background: #ff4d6d;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
            box-shadow: 0 0 8px #ff4d6d;
        }

        /* Circular Image Preview */
        .image-preview {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            border-radius: 50%;
            border: 4px solid #ff66b2;
            overflow: hidden;
            box-shadow: 0 0 15px #ff66b2;
            background: #fff;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Input fields */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 15px 20px;
            margin: 12px 0;
            border: none;
            border-radius: 30px;
            outline: none;
            font-size: 1rem;
            color: #333;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        select:focus {
            box-shadow: 0 0 10px #ff66b2;
            background: #ffe6f7;
        }

        /* Image upload input styling */
        input[type="file"] {
            margin-top: 15px;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        input[type="file"]::-webkit-file-upload-button {
            cursor: pointer;
            background: #ff3399;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            color: white;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: #e60073;
        }

        /* Submit button */
        button {
            margin-top: 30px;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 30px;
            background: #ff3399;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 0 15px #ff3399;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background: #e60073;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Registration</h2>

    <?php if (!empty($error)) : ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Image preview circle -->
    <div class="image-preview" id="imagePreview">
        <img src="https://via.placeholder.com/120?text=Profile" alt="Profile Image" id="imageDisplay" />
    </div>

    <form action="" method="POST" enctype="multipart/form-data" id="regForm">
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email Address" required />
        <select name="course" required>
            <option value="" disabled selected>Select Course</option>
            <option value="Software Engineering">Software Engineering</option>
            <option value="Web Development">Web Development</option>
            <option value="Data Science">Data Science</option>
            <option value="Mobile Apps">Mobile Apps</option>
        </select>
        <input type="tel" name="contact" placeholder="Contact Number" pattern="[0-9]{10,15}" title="Enter a valid contact number" required />

        <input type="file" name="image" id="imageInput" accept="image/*" required />

        <button type="submit" name="submit">Register</button>
    </form>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const imageDisplay = document.getElementById('imageDisplay');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imageDisplay.setAttribute('src', e.target.result);
            }

            reader.readAsDataURL(file);
        } else {
            imageDisplay.setAttribute('src', 'https://via.placeholder.com/120?text=Profile');
        }
    });
</script>

</body>
</html>