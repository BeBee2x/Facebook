<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Messenger</title>
    <link rel="shortcut icon" href="{{ asset('images/3d-render-meta-chat-messenger-facebook-messenger-icon-bubble-isolated-on-transparent-background-free-png.webp') }}" type="image/x-icon">
    {{-- bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    {{-- google fonts roboto --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html {
            scroll-behavior: smooth;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .btn-hover2:hover {
            background-color: #e5e5ea6f;
        }

        .btn-hover:hover {
            background-color: #e7e9ec;
        }

        .bg-select {
            background-color: #e7e9ec;
        }

        .effect {
            background-color: rgb(247, 11, 11);
            padding: 13px;
            border-radius: 50%;
            margin-right: 10px
        }

        .border-effect {
            border: solid 3px blue;
            border-radius: 50%
        }

        .border-effect-normal {
            border: solid 3px white;
            border-radius: 50%;
        }

        .underline:hover {
            text-decoration: underline 2px
        }

        .bg-unread{
            background-color: rgb(184, 208, 255);
        }

        .bg-icon{
            background-color: #D8DADF
        }

    </style>
</head>
<body style="background-color: #ffffff; font-family: 'Roboto'">
    @yield('content')
</body>
{{-- bootstrap js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@yield('script')

</html>
