<?php
include 'config.php';


$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(145deg, #090979, rgb(52, 211, 243));
            font-family: 'Outfit', sans-serif;
            color: #fff;
            padding-top: 30px;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 25px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
            text-align: center;
            color: #fff;
            margin-bottom: 30px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #00e5ff;
            margin-bottom: 15px;
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            color: #00e5ff;
            font-size: 2.2rem;
            text-shadow: 0 0 15px #00e5ff;
            margin-bottom: 40px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 30px;
            padding: 10px 20px;
            background: linear-gradient(135deg, rgba(29, 161, 175, 0.8), #007bff);
            color: #000;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            transition: 0.3s ease;
            text-decoration: none;
        }

        .back-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px #00e5ff;
            color: #000;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🎓 Registered Student Profiles</h2>
    <div class="text-center mb-4">
        <a href="index.php" class="back-btn">← Go Back</a>
    </div>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="profile-card">
                        <img class="profile-img" src="upload/<?php echo htmlspecialchars($row['image']); ?>" alt="Profile">
                        <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p><strong>Contact:</strong> <?php echo htmlspecialchars($row['contact']); ?></p>
                        <p><strong>Course:</strong> <?php echo htmlspecialchars($row['course']); ?></p>
                        <td>
    <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-action btn-edit me-1">
        <i class="bi bi-pencil-square"></i> Edit
    </a>
    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-action btn-delete"
       onclick="return confirm('Are you sure you want to delete this student?');">
        <i class="bi bi-trash-fill"></i> Delete
    </a>
</td>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No student profiles found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
