
<!DOCTYPE html> 
<html>
    <head>
        <title>remove later</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/package.css">
        <link rel="stylesheet" href="css/comments.css">
        
        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        </style>
    </head>
    <body>
        <div class="mb-3" style="position: relative;text-align: left;">
            <label for="upload-file" class="form-label fw-bold">Select File <sm class="text-secondary" style="font-size: 12px;">(pdf, txt, image or word)</sm></label>
        
            <div class="uploadfile" id="upload-file">
                <label class="btn addpic" style="margin: 0 auto;display: flex;align-items: center;justify-content: center;" for="selectfile"> 
                    <input class="uploadfromlib" id="selectfile" name="file" type="file" style="display:none;" accept="image/*, .pdf, .docx, .doc, .txt">
                    <input type="hidden" id="agent-file" name="agent-file" value="">
                
                    <div style="text-align: center;font-size: 30px;">
                        <i class="fa fa-file-circle-plus"></i>
                    </div>
                </label>
            </div>

            <div class="upload_loader fa-3x d-none">
                <i class="fas fa-spinner fa-pulse"></i>
            </div>
        </div>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- font awesome library -->
        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>

        <script src="js/file-upload.js"></script>
        
    </body>

</html>