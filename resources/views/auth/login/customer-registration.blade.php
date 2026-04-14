<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            background: #DCDDDF;
            font: 14px Arial;
        }

        .container {
            width: 400px;
            margin: 50px auto;
        }

        #content {
            background: #f9f9f9;
            border: 1px solid #c4c6ca;
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px;
        }

        #content h1 {
            color: #7E7E7E;
            margin-bottom: 25px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 90%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        input:focus {
            border-color: #ed1c24;
        }

        input[type="submit"] {
            background: #fec151;
            border: none;
            padding: 12px;
            width: 120px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background: #fcb040;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin: 10px 15px;
        }

        .links a {
            font-size: 13px;
            color: #004a80;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <section id="content">

        <form method="POST" action="{{ url('/customer/registration-store') }}" enctype="multipart/form-data">
            @csrf

            <h1>Customer Registration</h1>

            <input type="text" name="name" placeholder="Full Name" required>

            <input type="text" name="phone" placeholder="Phone Number" required>

            <input type="email" name="email" placeholder="Email Address" required>

            <input type="password" name="password" placeholder="Password" required>

            <!-- Optional Image -->
            <input type="file" name="image" accept="image/*">

            <div class="links">
                <a href="{{ url('/customer/login') }}">Already have account?</a>
                <a href="{{ url('/') }}">Home</a>
            </div>

            <input type="submit" value="Register">

        </form>

    </section>
</div>

</body>
</html>