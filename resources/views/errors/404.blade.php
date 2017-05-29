<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>García Electricidad Error</title>
	<link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
	<style>
		.margen{
			margin:30% auto 0 auto;
		}
		.margen2{
			margin-top:2%;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-4 col-md-offset-4">
				<img class="img-responsive margen" width="300px" src="{{asset("images/torres.jpeg")}}" alt="Logo García">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-4 col-md-offset-4 text-center">
				<h2>¡Ocurrió un error!</h2>
			</div>
		</div>
		<div class="row margen2">
			<div class="col-xs-12 col-md-4 col-md-offset-4 text-center">
				<a href="{{url('/')}}" class="btn btn-danger btn-lg">Regresar</a>
			</div>
		</div>
	</div>
	
</body>
</html>