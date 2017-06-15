<?php
/**
 * Template for Page 404
 */

// Tribe Events hack - create empty post object
global $post;
if (!isset($post)) {
	$post = new stdClass();
	$post->post_type = 'unknown';
}
// End Tribe Events hack

// get_header();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="icon" type="image/x-icon" href="https://trustdentalcare.com/wp-content/uploads/2016/12/TDC-site-icon.jpg">
		<title>Page Not Found 404</title>
		<style media="screen">
			body {
				margin: 0;
				background: #00aeef;
			}
			h1,h2,p {
				color:#fff;
			}
			h1 {
				font-family: sans-serif;
    		font-size: 4em;
			}
			h2 {
				font-size: 3em;
				font-family: sans-serif;
				margin-bottom: 0;
			}
			p {
				font-family: sans-serif;
				margin-top: 0;
				text-align: center;
			}
			.evil {
				width: 70%;
				margin: auto;
			}
			.error-page {
				display: flex;
		    align-items: center;
				justify-content: center;
		    flex-direction: column;
		    height: 100vh;
				background-image: url("https://trustdentalcare.com/wp-content/uploads/plugs.png");
				background-repeat: no-repeat;
		    background-position: 0;
		    background-size: 100%;
			}
			.container {
				text-align: center;
			}
			.buttons {
				margin-top: 50px;
			}
			a {
				font-family: sans-serif;
				background: #ffcc00;
				border: none;
				margin: 10px;
				padding: 15px;
				text-decoration: none;
		    color: #000;
		    margin: 20px;
				display: inline-block;
			}
			@media screen and (max-width: 800px) {
				body {
					font-size: 12px;
				}
				.evil {
					margin: auto;
				}
				.evil img {
					width: 100%;
				}
				.error-page {
					background-image: none;
				}
			}
		</style>
	</head>
	<body>
		<div class="error-page">
			<div class="container">
				<h1>Oops...</h1>
				<div class="evil">
					<img src="https://trustdentalcare.com/wp-content/uploads/evil-grim.png" alt="">
				</div>
				<h2>PAGE NOT FOUND</h2>
				<p>We are trying to remove all plaque from this page</p>

				<div class="buttons">
					<a href="https://trustdentalcare.com/">GO BACK HOME</a>
					<a href="https://trustdentalcare.com/contact/">CONTACT US</a>
				</div>

		</div>
		</div>
	</body>
</html>


<?php
// get_footer();
?>
