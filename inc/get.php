<?php flash('upload'); ?>
<form enctype="multipart/form-data" method="post">
    <div>
        <label for="file">Select a file:</label>
        <input type="file" id="file" name="file"/>
    </div>
    <div>
        <button type="submit">Upload</button>
    </div>
</form>
