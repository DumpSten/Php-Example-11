
<a href="index.php?sayfa=categories_add">[Kategori Ekle]</a>

<?php 

$categories = $db->query('SELECT categories.*,COUNT(lessons.id) as lessonsPlus FROM categories
LEFT JOIN lessons ON FIND_IN_SET (categories.id, lessons.categories_id) GROUP BY categories.id')->fetchAll(PDO::FETCH_ASSOC);

?>
<ul>
    <?php  foreach ($categories as $categorie): ?>
        <li>
            <a href="index.php?sayfa=categorie&id=<?php echo $categorie['id'] ?>">
            <?php echo $categorie['ad'] ?>
            (<?php echo $categorie['lessonsPlus'] ?>)
            </a>
        </li>
    <?php endforeach; ?>
</ul>