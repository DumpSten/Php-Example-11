
<?php 

$categories = $db->query('SELECT * FROM categories ORDER BY ad ASC')->fetchAll(PDO::FETCH_ASSOC);


if ($_POST) {
    $baslik = $_POST["baslik"] ?? null;
    $icerik = isset($_POST["icerik"]) ? $_POST["icerik"]:null;
    $onay = isset($_POST["onay"]) ? $_POST["onay"]: 0 ;
    $categories_id = isset($_POST["categories_id"]) && is_array($_POST['categories_id']) ? implode(',', $_POST["categories_id"]):null;

    if (!$baslik) {
        echo "Başlık Ekleyin";
    }elseif (!$icerik) {
        echo "İçerik Ekleyin";
    }elseif (!$categories_id) {
        echo "Kategori Seçin.";
    }else {
        $sorgu = $db->prepare( 'INSERT INTO lessons SET
        baslik = ?,
        icerik = ?,
        onay = ?,
        categories_id = ?');
        $ekle = $sorgu->execute([
            $baslik,$icerik,$onay,$categories_id ]);
            $lastID = $db->lastInsertID();
            
        if ($ekle) {
            header('Location:index.php?sayfa=read&id=' . $lastID);
        }else {
            $error = $sorgu->errorInfo();
            echo 'Mysql Hatası:'. $error[2];
        }   
    }
}
    
?>
<form action="" method="post">
    Başlık:<br>
    <input type="text" name='baslik'><br> <br>
    
    İçerik:<br>
    <textarea name="icerik" cols="30"
        rows="10"></textarea><br> <br>
    
    Kategorei:<br>
    <select name="categories_id[]" >
        <?php foreach ($categories as $categorie):?>
            <option value="<?php echo $categorie['id'] ?>"><?php echo $categorie['ad'] ?></option>
        <?php endforeach; ?>    
    </select><br> <br>

    Onay:<br>    
    <select name="onay">
        <option value="1">Onaylı</option>
        <option value="0">Onaylı Değil</option>
    </select>
    <button type="submit">Gönder</button>
</form>