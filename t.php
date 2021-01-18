<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <style>
        html {
            margin: 0;
            background-color: black;
        }
        /* .grid {
            margin: auto;
            width: 80%;
            display: grid;
            grid-template-columns: 33% 33% 33%;
            gap: 10px;
            justify-items: center;
            align-items: center;
            grid-auto-flow: row;
            grid-auto-rows: auto;
        }

        .item {
            width: 100%;
        }

        .item .content img {
            width: 100%;
        }

        @media only screen and (max-width: 1500px) {
            .grid {
                width: 90%;
                grid-template-columns: 50% 50%;
            }
        }

        @media only screen and (max-width: 1024px) {
            .grid {
                width: 100%;
                grid-template-columns: 100%;
            }
        } */

        .grid {
            width: 80%;
            margin: auto;
            display: grid;
            grid-gap: 10px;
            grid-template-columns: repeat(auto-fill, minmax(400px,1fr));
            grid-auto-rows: 1px;
        }

        .item .content img {
            width: 100%;
        }

        .content {
            position: relative;
            margin: auto;
            overflow: hidden;
        }

        .content .content-overlay {
            background: rgba(0,0,0,0.7);
            position: absolute;
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
            opacity: 0;
            -webkit-transition: all 0.4s ease-in-out 0s;
            -moz-transition: all 0.4s ease-in-out 0s;
            transition: all 0.4s ease-in-out 0s;
        }

        .content:hover .content-overlay{
            opacity: 1;
        }

        .content-details {
            position: absolute;
            text-align: center;
            padding-left: 1em;
            padding-right: 1em;
            width: 100%;
            top: 50%;
            left: 50%;
            opacity: 0;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease-in-out 0s;
        }

        .content:hover .content-details{
            top: 50%;
            left: 50%;
            opacity: 1;
        }

        .content-details h3{
            color: #fff;
            letter-spacing: 0.15em;
            margin-bottom: 0.5em;
            text-transform: uppercase;
        }

        .content-details h4{
            color: #fff;
            margin-bottom: 0.5em;
        }

        .content-details p{
            color: #fff;
            font-size: 0.8em;
        }

        .fadeIn-bottom{
            top: 80%;
        }

        @media only screen and (max-width: 1024px) {
            .grid {
                width: 100%
            }
        }
        
    </style>
</head>
<body>
    <main>
        <div class="page-title">
            <h1>Photographies</h1>
        </div>
        <div class="page-selector" id="selector">
            <button id="toutes" onclick="activateBtn('toutes')" class="active">Toutes</button>
            <button id="pro" onclick="activateBtn('pro')">Professionnelles</button>
            <button id="perso" onclick="activateBtn('perso')">Personnelles</button>
        </div>

        <div class="grid">
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/1.jpg" alt="img1">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Titre de la photo</h3>
                        <h4 class="content-subtitle">Lieu</h4>
                        <p class="content-text">Dec</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/2.jpg" alt="img2">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/3.jpg" alt="img3">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/4.jpg" alt="img4">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/5.jpg" alt="img5">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="content">
                    <div class="content-overlay"></div>
                    <img src="img/6.jpg" alt="img6">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">This is a title</h3>
                        <p class="content-text">This is a short description</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script>
        function resizeGridItem(item){
            grid = document.getElementsByClassName("grid")[0];
            rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
            rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
            rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
                item.style.gridRowEnd = "span "+rowSpan;
        }

        function resizeAllGridItems(){
            allItems = document.getElementsByClassName("item");
            for(x=0;x<allItems.length;x++){
                resizeGridItem(allItems[x]);
            }
        }

        function resizeInstance(instance){
                item = instance.elements[0];
            resizeGridItem(item);
        }

        window.onload = resizeAllGridItems();
        window.addEventListener("resize", resizeAllGridItems);

        allItems = document.getElementsByClassName("item");
        for(x=0;x<allItems.length;x++){
            imagesLoaded( allItems[x], resizeInstance);
        }
    </script>
</body>
</html>