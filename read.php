
<?php

if (!isset($_GET['id']) || empty($_GET['id']) ) {
    header('Location:index.php');
    exit;
}   

$sorgu = $db->prepare('SELECT * FROM lessons WHERE id=? && onay = 1');
$sorgu->execute([$_GET['id']]);
$lesson = $sorgu->fetch(PDO::FETCH_ASSOC);
if (!$lesson) {
    header('Location:index.php');
    exit;
}

?>
<h3><?php echo $lesson['baslik'] ?></h3>

<div>
    <strong>Yayın Tarihi :</strong><?php  echo $lesson['date'] ?><hr>
    <?php echo $lesson['icerik'] ?>
</div>