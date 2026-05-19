<!DOCTYPE html>
<html>
	<head>
	<title>How To Generate PDF File In Laravel 10 - Websolutionstuff</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<h1></h1>
		<p></p>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
		<div class="container">
			<div class="row">
			<div class="col-lg-12" style="margin-top: 15px">				
				<div class="pull-right">
					<a class="btn btn-primary" href="{{route('indexpdf',['download'=>'pdf'])}}">Download PDF</a>
				</div>
			</div>
			</div><br>
			<table class="table table-bordered">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
			</tr>
		
			<tr>
				<th>0</th>
				<td>0</td>
				<td>0</td>
			</tr>
	
			</table>
		</div>
	</body>
</html>