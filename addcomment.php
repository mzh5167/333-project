<?php
// require("html/document_before.php");
?>
<h1>Add Comment</h1>
<form action="comment.php" method="post">
    <input type="hidden" name="pid" value="<?php echo $_GET['pid'] ?>">
    <label for="c">Leave comment</label>
    <textarea name='comment' class="form-control" id="c" rows="5"></textarea>
    <button type="submit" class="btn btn-primary">Comment</button>
</form>
<?php
// require("html/document_after.php");
?>
