<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$age = $_POST['age'];
	$dirUpload = 'images/';
	$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$extensions_ok = ['jpg', 'jpeg', 'webp'];
	$maxSize = 1000000;
	$errors = [];
	if (empty($firstName) || empty($lastName) || empty($age)) {
		$errors[] = 'Merci de bien vouloir rentrez tous les champs';
	}

	if (!in_array($extension, $extensions_ok)) {
		$errors[] = 'Merci de bien vouloir respecter les bon formats (Jpeg, Jpg, Webp)';
	}

	if (file_exists($_FILES['file']['tmp_name']) && filesize($_FILES['file']['tmp_name']) > $maxSize) {
		$errors[] = 'Merci de déposer des fichiers de moins de 2Mo';
	}

	if (count($errors) === 0) {
        $newName = md5(uniqid()) . '_' . basename($_FILES['file']['name']);
		move_uploaded_file($_FILES['file']['tmp_name'], $dirUpload . $newName);
	}
}
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>Upload files</title>
</head>
<body>
<div class="container d-flex justify-content-center mt-4">
	<h1>Upload file</h1>
</div>
<div class="container m-auto">
	<div class="row d-flex justify-content-center">
		<div class="col-6">
			<form action="form.php" method="post" enctype="multipart/form-data" class="border p-4">
				<?php if (!empty($errors)):?>
					<div class="alert alert-danger">
						<?= $errors[0] ?>
					</div>
				<?php endif; ?>
                <div class="mb-3">
                    <label for="firstname" class="form-label">Entrez votre prénom</label>
                    <input class="form-control" type="text" id="firstname" name="firstname">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Entrez votre nom</label>
                    <input class="form-control" type="text" id="lastname" name="lastname">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Entrez votre âge</label>
                    <input class="form-control" type="number" id="age" name="age">
                </div>
				<div class="mb-3">
					<label for="formFile" class="form-label">Choisissez un fichier</label>
					<input class="form-control" type="file" id="formFile" name="file">
				</div>
				<div class="mb-3">
					<button class="btn btn-primary">Envoyer</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php if (isset($firstName) && isset($lastName) && isset($age)): ?>
<div class="container">
	<div class="row">
		<div class="card">
			<?= isset($newName) ? '<img src="images/' . $newName . '" class="card-img-top" alt="...">' : '' ?>
			<div class="card-body">
				<h5 class="card-title"><?= $firstName ?> <?= $lastName ?></h5>
				<p class="card-text"><?= $age ?></p>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
