<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="container" x-data="{ message: 'Hello Alpine' }">
        <div class="row">
            <div class="col-12" x-text="message"></div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
