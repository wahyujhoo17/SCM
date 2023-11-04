<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/login.css" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' />
    <title>Login</title>

</head>

<body>
    <div class="backroundC">
        <div class="container">
            {{-- <img class="logo" src="https://cdn.vectorstock.com/i/1000x1000/53/97/ja-logo-design-premium-letter-vector-37075397.webp" alt="Logo"> --}}
            <p id="larger" class="margin-l">Masuk</p>
            <!-- USERNAME -->
            <form action="{{ route('login') }}" method="post">
                @csrf
                <p id="smaller" class="margin-l">Masukkan username</p>
                <input type="text" class="margin-l" name="email" id="idusername" placeholder="Username" required />
                <br>
                @error('email')
                    <span class="" role="alert" style="margin-left: 10%">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <br />
                <br />
                <!-- PASSWORD -->
                <p for='idpassword' id="smaller" class="margin-l">Masukkan kata sandi</p>
                <input type="password" class="margin-l" name="password" id="idpassword" required
                    placeholder="Password" />
                <br />
                <br />
                <input type="checkbox" class="margin-l" id="box" onclick="myFunction()" />
                <label id="smaller" for="box">Show Password</label>
                <!-- LUPASANDI --><br />
                <br />
                <a id="lupa-password" href="">Lupa kata sandi?</a>
                <!-- BUTTON MASUK --><br />
                <br />
                <input type="submit" id="btnMasuk" value="Masuk" />
                {{-- <button type="submit" >Masuk</button> --}}
            </form>
        </div>

    </div>

</body>
<!-- HIDE LOGIN -->
<script>
    function myFunction() {
        var x = document.getElementById("idpassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

</html>
