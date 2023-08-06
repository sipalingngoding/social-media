<?php flash(); ?>
<form enctype="multipart/form-data" method="post">
    <div>
        <label for="file1">Select a file:</label>
        <input type="file" id="file1" name="files[]" multiple />
    </div>
    <div>
        <label for="file2">Select a file:</label>
        <input type="file" id="file2" name="files[]" multiple/>
    </div>
    <div>
        <button type="submit">Upload</button>
    </div>
</form>
