<?php   										// Opening PHP tag
	
	// Include the database connection script
	require 'includes/database-connection.php';

	// Retrieve the value of the 'toynum' parameter from the URL query string
	//		i.e., ../toy.php?toynum=0001
	$toy_id = $_GET['toynum'];


	/*
	 * TO-DO: Define a function that retrieves ALL toy and manufacturer info from the database based on the toynum parameter from the URL query string.
	 		  - Write SQL query to retrieve ALL toy and manufacturer info based on toynum
	 		  - Execute the SQL query using the pdo function and fetch the result
	 		  - Return the toy info

	 		  Retrieve info about toy from the db using provided PDO connection
	 */
	function getToyInfo(PDO $pdo) {
		if (!isset($_GET['toynum'])) {
			return null; // or handle error appropriately
		}
		$toynum = $_GET['toynum'];
	
		// SQL query to retrieve all toy and manufacturer info
		$sql = "
			SELECT 
    			toy.*, 
   				manuf.name AS manuf_name, 
   				manuf.street AS manuf_street, 
    			manuf.city AS manuf_city, 
    			manuf.state AS manuf_state, 
    			manuf.zipcode AS manuf_zipcode, 
    			manuf.phone AS manuf_phone, 
    			manuf.contact AS manuf_contact
			FROM toy
			INNER JOIN manuf ON toy.manid = manuf.manid
			WHERE toy.toynum = :toynum
		";
	
		// Prepare the statement
		$stmt = $pdo->prepare($sql);
	
		// Bind the toynum parameter
		$stmt->bindParam(':toynum', $toynum, PDO::PARAM_INT);
	
		// Execute the query
		$stmt->execute();
	
		// Fetch the result as an associative array
		$toyInfo = $stmt->fetch(PDO::FETCH_ASSOC);
	
		// Return the result
		return $toyInfo;
	}
	
	$toy = getToyInfo($pdo);

// Closing PHP tag  ?> 

<!DOCTYPE>
<html>

	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>Toys R URI</title>
  		<link rel="stylesheet" href="css/style.css">
  		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
	</head>

	<body>

		<header>
			<div class="header-left">
				<div class="logo">
					<img src="imgs/logo.png" alt="Toy R URI Logo">
      			</div>

	      		<nav>
	      			<ul>
	      				<li><a href="index.php">Toy Catalog</a></li>
	      				<li><a href="about.php">About</a></li>
			        </ul>
			    </nav>
		   	</div>

		    <div class="header-right">
		    	<ul>
		    		<li><a href="order.php">Check Order</a></li>
		    	</ul>
		    </div>
		</header>

		<main>
			<!-- 
			  -- TO DO: Fill in ALL the placeholders for this toy from the db
  			  -->
			
			<div class="toy-details-container">
			
				<div class="toy-image">
					<!-- Display image of toy with its name as alt text -->
					<img src="<?= $toy['imgSrc'] ?>" alt="<?= $toy['name'] ?>">
				</div>

				<div class="toy-details">

					<!-- Display name of toy -->
			        <h1><?= $toy['name'] ?></h1>

			        <hr />

			        <h3>Toy Information</h3>

			        <!-- Display description of toy -->
			        <p><strong>Description:</strong> <?= $toy['description'] ?></p>

			        <!-- Display price of toy -->
			        <p><strong>Price:</strong> $ <?= $toy['price'] ?></p>

			        <!-- Display age range of toy -->
			        <p><strong>Age Range:</strong> <?= $toy['agerange'] ?></p>

			        <!-- Display stock of toy -->
			        <p><strong>Number In Stock:</strong> <?= $toy['numinstock'] ?></p>

			        <br />

			        <h3>Manufacturer Information</h3>

			        <!-- Display name of manufacturer -->
			        <p><strong>Name:</strong> <?= $toy['manuf_name'] ?> </p>

			        <!-- Display address of manufacturer -->
			        <p><strong>Address:</strong> <?= $toy['manuf_street'] . ', ' . $toy['manuf_city'] . ', ' . $toy['manuf_state'] . ' ' . $toy['manuf_zipcode'] ?></p>

			        <!-- Display phone of manufacturer -->
			        <p><strong>Phone:</strong> <?= $toy['manuf_phone'] ?></p>

			        <!-- Display contact of manufacturer -->
			        <p><strong>Contact:</strong> <?= $toy['manuf_contact'] ?></p>
			    </div>
			</div>
		</main>

	</body>
</html>
