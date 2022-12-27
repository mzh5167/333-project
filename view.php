<?php
require('connection.php');
try {
    if (!isset($_GET['id']))
        die("Place id was not provided");
    $pid = $_GET['id'];
    $query = $db->prepare("SELECT p.*,c.*, AVG(rating)
        FROM places p LEFT JOIN reservation r
        ON p.pid = r.pid LEFT JOIN comments c
        ON p.pid = c.pid
        WHERE p.pid = ?");
    $query->execute([
        $pid
    ]);

    $queryComment = $db->prepare("SELECT u.fname,c.comment
        FROM users u, comments c WHERE
        pid = ? AND u.uid = c.uid");
    $queryComment->execute([
        $pid
    ]);
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
<?php
$page = 'minor';
$pageName = 'Place Datails';
require 'html/document_before.php'; ?>
<div class="container mt-5">
    <?php while ($row = $query->fetch(PDO::FETCH_OBJ)) { ?>
        <div class="row">
            <div class="col-12 col-md-4">
                <img src="images/<?php echo "$row->image"; ?>" class="img-fluid img-thumbnail h-100">
            </div>
            <div class="col-12 col-md-8">
                <h1><?php echo "$row->name"; ?></h1>
                <p><i class="bi bi-star-fill" style="color:orange;"></i> Rating: <?php echo  bcdiv($_GET['rating'], "1"); ?></p>
                <div class="text-wrap text-break">
                    <h4><?php echo "$row->description"; ?></h4>
                </div>
                <h4><?php echo "$row->category"; ?></h4>

            </div>
        </div>
</div>
<?php
    }
?>
<?php require 'html/document_after.php'; ?>