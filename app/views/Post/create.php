<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/style.css">
</head>
<body>
    <h1>Create Post</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br>
        <label for="body">Desc:</label>
        <textarea name="body" id="body" required></textarea><br>
        <input type="button" onclick="AddOptions()" value="Add Option"><br>  
        <input type="submit" value="Create">
        </form>
        <a href="<?php echo BASEURL ?>">Home</a>
        <script>
            var optionCount = 0
            function AddOptions() {
                optionCount = optionCount + 1;
                var newOptionId = 'option_name[' + optionCount + ']';
                var newOptionInput = document.createElement('input');
                newOptionInput.type = 'text';
                newOptionInput.name = 'option_name';
                newOptionInput.id = newOptionId;
                newOptionInput.name = newOptionId;
                newOptionInput.required = true;
                newOptionInput.placeholder = 'Option ' + (optionCount);

                var newOptionImageId = 'option_image[' + optionCount + ']';
                var newOptionImageInput = document.createElement('input');
                newOptionImageInput.type = 'file';
                newOptionImageInput.name = 'option_image';
                newOptionImageInput.id = newOptionImageId;
                newOptionImageInput.name = newOptionImageId;
                newOptionImageInput.required = false;
                newOptionImageInput.accept = 'image/*';
                newOptionImageInput.placeholder = 'Image ' + (optionCount);

                document.querySelector('form').insertBefore(newOptionInput, document.querySelector('input[type="submit"]'));
                document.querySelector('form').insertBefore(document.createElement('br'), document.querySelector('input[type="submit"]'));
                document.querySelector('form').insertBefore(newOptionImageInput, document.querySelector('input[type="submit"]'));
                document.querySelector('form').insertBefore(document.createElement('br'), document.querySelector('input[type="submit"]'));
            }
        </script>
</body>
</html>
