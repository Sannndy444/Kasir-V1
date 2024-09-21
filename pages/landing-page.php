<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- My Style -->
    <style>
        :root {
            --primary: #E3E1D9;
            --bg: #F2EFE5;
            --third: #C7C8CC;
            --nav: #495464;
            --font: #424242;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            align-items: center;    /* Center elements horizontally */
            padding: 3rem;
            text-align: center;     /* Center text */
        }

        .welcome {
            padding: 1rem 0;
        }

        .welcome h2 {
            font-size: 2rem;
            color: var(--font);
        }

        .signup {
            margin-top: 1.5rem;  /* Add margin to create space between image and button */
        }

        .signup a button {
            padding: 1rem 2rem;
            background-color: var(--nav);
            color: white;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            font-size: 1rem;
        }

        .signup a button:hover {
            background-color: var(--primary);
        }

        @media screen and (max-width: 1024px) and (min-width: 769px) {
            .container {
                padding: 2rem;  /* Reduce padding for smaller screens */
            }

            .welcome img {
                width: 100%;  /* Make image responsive */
                max-width: 300px;
            }

            .signup a button {
                width: 100%;
            }
        }

        /* Optional: Responsiveness for smaller screens */
        @media only screen and (max-width: 768px) and (min-width: 0px) {
            .container {
                padding: 5rem 0 0 0;  /* Reduce padding for smaller screens */
            }

            .welcome img {
                width: 100%;  /* Make image responsive */
                max-width: 300px;
            }

            .signup a button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h2>Selamat Datang Di KaSi</h2>
            <img src="../assets/2.png" alt="" width="300">
        </div>
        <div class="signup">
            <a href="pages/signup-page.php"><button type="button">Sign Up</button></a>
        </div>

        
    </div>
</body>
</html>