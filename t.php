<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * {
            margin: 0;
        }
div {
    height: 100%;
    width: 100%;
}
.div1 {
    position: absolute;
    clip-path: polygon(100% 0, 0 0, 0 100%);
}
.div2 {
    position: absolute;
    clip-path: polygon(100% 0, 0 100%, 100% 100%);
}
img {
    height: 100vh;
}
    </style>
</head>
<body>
    <div class="div1">
        <img src="includes/index1.jpg" alt="">
    </div>
    <div class="div2">
    <img src="includes/index2.jpg" alt="">
    </div>
    d
</body>
</html>