<?php   
if (!isset($_GET['id']) || empty($_GET['id']) ) {
    header('Location:index.php?sayfa=categories');
    exit;
}

$sorgu = $db->prepare('SELECT * FROM categories WHERE id = ?');
$sorgu->execute([$_GET['id']]);
$categorie = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$categorie) {
    header('Location:index.php?sayfa=categories');
    exit;
}


$sorgu = $db->prepare('SELECT * FROM lessons WHERE FIND_IN_SET (?, categories_id) ORDER BY id DESC');
$sorgu->execute([$categorie['id']]);
$lessons = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<h3><?php  echo $categorie['ad'] ?> Kategorisi</h3>
<?php if ($lessons) : ?>
<ul>
    <?php foreach ($lessons as $lesson ):?>
    <li>
        <?php echo $lesson['baslik']; ?>
        <div>
            <?php if ($lesson['onay'] == 1 ):?>
            <a href="index.php?sayfa=read&id=<?php echo $lesson['id'] ?>">[READ]</a>
            <?php endif; ?>
            <a href="index.php?sayfa=update&id=<?php echo $lesson['id'] ?>">[UPDATE]</a>
            <a href="index.php?sayfa=delete&id=<?php echo $lesson['id'] ?>">[DELETE]</a>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
 BU Kategoriye Ait Ders Bulunmuyor.
<?php endif; ?>