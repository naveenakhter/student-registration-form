<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $contact = $_POST['contact'];

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if ($image != '') {
        $path = "uploads/" . basename($image);

        if (move_uploaded_file($tmp_name, $path)) {
            $sql = "INSERT INTO students (name, email, course, contact, image) 
                    VALUES ('$name', '$email', '$course', '$contact', '$image')";
            $conn->query($sql);

            header('Location: view.php');
            exit();
        } else {
            echo "Failed to upload image.";
            exit();
        }
    } else {
        echo "Please select an image to upload.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register Student</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

body {
    margin: 0;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
   background: linear-gradient(145deg, #090979,rgba(41, 166, 190, 0.9));
    font-family: 'Poppins', sans-serif;
    color: #fff;
}

.container {
    max-width: 500px;
            margin: 50px auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 25px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 40px rgba(0, 255, 255, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
}

h2 {
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            color: #00e5ff;
            font-size: 2.2rem;
            text-shadow: 0 0 15px #00e5ff;
            margin-bottom: 30px;
        }

/* Image preview round style */
.image-preview {
    width: 130px;
    height: 130px;
    margin: 0 auto 25px;
    border-radius: 50%;
        border: 3px solid #00e5ff;
    overflow: hidden;
    background:  rgba(0, 162, 255, 0.6);
    box-shadow: 0 0 12px rgba(0, 162, 255, 0.6);
    transition: transform 0.3s ease;
}
.image-preview:hover {
    transform: scale(1.05);
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    background: rgba(1, 101, 160, 0.6);
}

/* Inputs */
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="course"],
select {
    width: 95%;
    padding: 12px 0px;
    margin: 15px 0;
    margin-right: 20px;
    border-radius: 50px;
    border: 1px solid #3498db;
    outline: none;
    font-size: 1rem;
    color: #2c3e50;
    background: #ecf0f1;
    font-weight: 500;
    transition: all 0.3s ease;
    text-align: center;
}

input:focus,
select:focus {
    background: #d6eaf8;
    box-shadow: 0 0 10px rgba(52, 152, 219, 0.8);
}

/* File input */
input[type="file"] {
    margin-top: 15px;
    width: 100%;
    border-radius: 50px;
    padding: 10px;
    background: #2980b9;
    border: none;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="file"]:hover {
    background: #1f618d;
}

input[type="file"]::-webkit-file-upload-button {
    cursor: pointer;
    background: #3498db;
    border: none;
    padding: 10px 20px;
    border-radius: 50px;
    color: white;
    font-weight: 700;
    transition: background-color 0.3s ease;
}

input[type="file"]::-webkit-file-upload-button:hover {
    background: #2471a3;
}

/* Submit button */
button {
    margin-top: 30px;
    width: 100%;
    padding: 14px 0;
    border: none;
    border-radius: 50px;
    background: linear-gradient(to right, #1abc9c, #3498db);
    font-size: 1.2rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    box-shadow: 0 0 20px rgba(52, 152, 219, 0.7);
    transition: all 0.3s ease;
    letter-spacing: 1px;
}

button:hover {
    background: linear-gradient(to right, #16a085, #2980b9);
    box-shadow: 0 0 25px rgba(52, 152, 219, 1);
}

/* Placeholder style */
::placeholder {
    color: solid #00e5ff;
    font-weight: 500;
    opacity: 0.9;
    background: solid #00e5ff;
}
</style>
</head>
<body>

<div class="container">
    <h2>🎓 Student Profile Form</h2>

    <div class="image-preview" id="imagePreview">
        <img src="https://via.placeholder.com/130?text=Profile" alt="" id="imageDisplay" />
    </div>

    <form action="" method="POST" enctype="multipart/form-data" id="regForm">
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email Address" required />
        <select type="course" name="course" required>
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
    // Image preview circle
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
            imageDisplay.setAttribute('src', 'https://via.placeholder.com/130?text=Profile');
        }
    });
</script>

</body>
</html>