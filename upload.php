<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Uploading</title>
</head>

<body class="container">
    <?php
    if ($_FILES) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        $uploadSuccess = true;

        //kontrola souboru
        if ($_FILES['uploadedName']['error'] != 0) {
            echo "Chyba serveru při uploadu. ";
            $uploadSuccess = false;
        }

        elseif(file_exists($targetFile))
        {
            echo "Soubor již existuje. ";
            $uploadSuccess = false;
        }

        elseif($_FILES['uploadedName']['size'] > 8000000)
        {
            echo "Soubor je příliš velký. ";
            $uploadSuccess = false;
        }

        elseif($fileType !== "mp3" && $fileType !== "wav" && $fileType !== "wmv" && $fileType !== "mp4" && $fileType !== "avi" && $fileType !== "png" && $fileType !== "jpg" && $fileType !== "jpeg")
        {
            echo "Soubor má špatný typ. ";
            $uploadSuccess = false;
        }
        
        //přesun souboru
        if (!$uploadSuccess) {
            echo "Došlo k chybě uploadu. ";
        }
        else 
        {
            if (move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)) 
            {
                echo "Soubor " . basename($_FILES['uploadedName']['name']) . " byl uložen.";
                if($fileType === "png" || $fileType === "jpg" || $fileType === "jpeg")
                {                 
                    echo "<img src={$targetFile}";
                }
                elseif($fileType === "mp3" || $fileType === "wav")
                {
                    echo "<audio controls> <source src={$targetFile}>";
                }
                elseif($fileType === "wmv" || $fileType === "mp4" || $fileType === "avi")
                {
                    echo "<video width='480' height='270'controls> <source src={$targetFile}>";
                }
            }
            else
            {
                echo "Došlo k chybě uploadu. ";
            }
        }
    }
    ?>
    <form method='post' action='' enctype='multipart/form-data'>
        <div class="mb-3">
            <p class="form-label">Select image to upload:</p>
            <input type="file" name="uploadedName" class="form-control" accept="media/*" />
            <input type="submit" value="Nahrát" name="submit" class="btn btn-secondary" />
        </div>
    </form>
</body>

</html>