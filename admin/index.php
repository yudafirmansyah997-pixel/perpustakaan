<?php
session_start();  
 include "../main/connect.php"; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #07284aff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-box {
            width: 400px;
            animation: fadeIn 1s ease;
        }
        

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            width: 85px;
            height: 85px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            color: #2a5298;
            margin: auto;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
        }

        .brand-title {
            font-weight: 700;
            color: #2a5298;
        }

        .input-group-text {
            background-color: #e9ecef;
        }

        .btn-primary {
            background: #2a5298;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #1e3c72;
        }
        /* Hilangkan efek hover */
.form-control:hover {
    border-color: #ced4da !important;
}

/* Hilangkan border biru saat di klik (focus) */
.form-control:focus {
    border-color: #ced4da !important;
    box-shadow: none !important;
    outline: none !important;
}

    </style>
</head>
<body>

<div class="login-box">

    <div class="card shadow border-0 p-4">
        
        <div class="brand-logo mb-3">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h3 class="text-center brand-title mb-4">Admin Panel</h3>
        <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php } ?>


        <form action="../main/auth.php" method="POST">

            <!-- Username -->
            <div class="mb-3">
                <label class="fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Masukkan username..." required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan password..." required>
                </div>
            </div>

            <button class="btn btn-primary w-100 py-2 mt-2">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>

        </form>

    </div>

</div>

</body>
</html>
