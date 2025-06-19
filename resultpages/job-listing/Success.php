<html>
	<head>
		<link rel="stylesheet" href="../resultpages/css/update.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
		<style>
			@import url('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,800&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Signika:wght@600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Work+Sans:wght@500&display=swap');

body {
	background-color: #ced1de;
}

.container {
	display: flex;
	justify-content: center;
	margin-top: 70px;
}

.content {
	background-color: white;
	box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1);
	width:  500px;
	height: 540px;
	border-radius: 10px;
}

.content-heading  {
    color: black;
    font-size: 20px;
    margin: 30px;
    font-family: 'Kanit', sans-serif;

}

.content-heading hr {
	border: 1px solid #2253ab;
}

.content-icon {
	display: flex;
	justify-content: center;
}

.content-icon i {
	font-size: 70px;
	color: white;
	background-color: #79d198;
	padding: 20px;
	border-radius: 50%;
}

.content-text {
	text-align: center;
}

.content-text h2 {
	font-family: 'Kanit', sans-serif;
	color: #79d198;
}


.content-text p {
    color: black;
    font-size: 20px;
    margin: 30px;
    font-family: 'Signika', sans-serif;

}

.navigation-icons {
	display: flex;
	justify-content: center;
}

.navigation-icons i {
	font-size: 35px;
	margin: 20px;
	background-color: #2253ab;
	padding: 10px;
	color: white;
	border-radius: 50%;
}

#incorrect {
	color: white;
	background-color: #cc6c6c;
	padding: 25px;
}

#incorrect-h2 {
	color: #cc6c6c;
}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="content-heading">
					<h1>Success</h1>

					<hr>
				</div>
				<div class="content-icon">
					<i class="fa-solid fa-check"></i>
				</div>
				<div class="content-text">
					<h2>Verification Successful</h2>
					<p>Job listing created</p>
				</div>
				<div class="navigation-icons">
					<a href="http://localhost/Resumeister/agency/new-listing.php"><i id ="back-arrow" class="fa-solid fa-arrow-left"></i></a>
					<a href="http://localhost/Resumeister/agency/inactive-job-listings.php"><i id="dashboard-icon" class="fa-solid fa-briefcase"></i></a>

				</div>
			</div>
		</div>
	</body>
</html>