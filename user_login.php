<!DOCTYPE html>
<html lang="en">
<head>
   <title>User API Login</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

   <div class="container mt-5">
      <div class="card mx-auto" style="max-width: 400px;">
         <div class="card-header bg-white text-center">
            <h2 class="text-primary">User API Login</h2>
         </div>
         <div class="card-body">
            <form action="user_home.php" method="post" enctype="multipart/form-data">
               <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="uname" required>
               </div>
               <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="pwd" required>
               </div>
               <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Login</button>
               </div>
            </form>
         </div>
         <div class="card-footer text-center">
         <p class="text-center mt-3">Don't have an account? <a href="user_signup.php">Register here</a></p>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
