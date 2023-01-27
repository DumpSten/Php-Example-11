<h3>Lesson List</h3>

    <form action="" method="get" >
        <input type="text" class="date"  name='baslangic'  value="<?php echo isset($_GET['baslangic'])  ? $_GET['baslangic'] : '' ?>" placeholder="Baslangıç Tarihi">
        <input type="text" class="date"  name='bitis' value="<?php echo isset($_GET['bitis'])  ? $_GET['bitis'] : '' ?>" placeholder="Bitis Tarihi"><br>
        <input type="text" name="search" value="<?php echo isset($_GET['search'])  ? $_GET['search'] : '' ?>" placeholder="Lessons Search.. ">
        <button type="submit" >Search</button>
    </form>


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
 $('.date').datepicker({dateFormat: 'yy-mm-dd'});  
</script>

<?php
$where = [];
$sql = 'SELECT lessons.id, lessons.baslik, lessons.onay, GROUP_CONCAT(categories.ad) as categories_adi, GROUP_CONCAT(categories.id) as categorie_id FROM lessons INNER JOIN categories ON FIND_IN_SET(categories.id, lessons.categories_id)';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $where[]='(lessons.baslik LIKE "%'. $_GET['search'] .'%" || lessons.icerik LIKE "%'. $_GET['search'] .'%")' ;
}
if (isset($_GET['baslangic']) && !empty($_GET['baslangic']) && isset($_GET['bitis']) && !empty($_GET['bitis'])) {
    $where[]='lessons.date BETWEEN "' . $_GET['baslangic'] . ' 00:00:00" AND "' . $_GET['bitis'] . ' 23:59:59"';
}
if (count($where) > 0){
    $sql .= ' WHERE ' . implode(' && ', $where);
}
$sql .='GROUP BY lessons.id ORDER BY lessons.id DESC ';



$lessons = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
/*
$sorgu = $db->prepare('SELECT * FROM lessons WHERE id=?');
$sorgu->execute([7]);
$lessons = $sorgu->fetchAll(PDO::FETCH_ASSOC);

print_r($lessons);
*/
?>
<?php if($lessons): ?>
<ul>
    <?php foreach ($lessons as $lesson ):?>
    <li>
        <?php echo $lesson['baslik']; ?>
        <?php 
        $categoriesName = explode(' , ' , $lesson['categories_adi']); 
        $categoriesId = explode(' , ' , $lesson['categorie_id']);
        foreach ($categoriesName as $key => $value) {
            echo '<a href="index.php?sayfa=categorie&id=' . $categoriesId[$key] . '">' . $value . '</a>';
        }
        ?>
        (<?php echo $lesson['categorie_id']; ?>)
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
    <div>
        <?php if(isset($_GET['search'])): ?>
            Aradığınız Kriterler Uygun Ders Bulunamadı!
        <?php else: ?>
            Henüz  Eklenmiş Ders Bulunmuyor..   
        <?php endif; ?>
    </div>
<?php endif; ?>