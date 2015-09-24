<!DOCTYPE html>
<html>
<head>
	<title>. nano zen .</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Raleway:400,100,300,500,700,900);

		body {
			font-family: 'Raleway', sans-serif;
		}

		h1 {
			font-weight: 300;
		}

		h4 {
			font-weight: 100;
		}

		.container {
			margin-top: 50px;
		}
	</style>
</head>
<body>
	
	<div class="container">
		<h1>
			<?= $this->welcome; ?>
		</h1>

		<h4><?= $this->slogan; ?></h4>
	</div>

</body>
</html>