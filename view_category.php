<?php
// <editor-fold defaultstate="collapsed" desc="Delete category data using web service.">
$command = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($command) && $command == 'rem') {
    $id = filter_input(INPUT_GET, 'tod', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = array('api_key' => '132', 'id' => $id);
    Utility::curl_post('http://localhost/pw2_w09_ws/service/category/delete',
            $data);
}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Add category code block">
$submitPressed = filter_input(INPUT_POST, "btnSubmit");
if (isset($submitPressed)) {
    $name = filter_input(INPUT_POST, "txtCatName", FILTER_SANITIZE_SPECIAL_CHARS);
    $data = array('api_key' => '123', 'name' => $name);

    // <editor-fold defaultstate="collapsed" desc="Call ws code block. Can be replace with $wsReturn = Utility::curl_post('http://localhost/pw2_w09_ws/service/category/add', $data)">
    //  Memanggil web  service dengan curl_init
    $wsUrl = curl_init('http://localhost/pw2_w09_ws/service/category/add');
    curl_setopt($wsUrl, CURLOPT_POST, TRUE);
    curl_setopt($wsUrl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($wsUrl, CURLOPT_RETURNTRANSFER, TRUE);
    //  Mengeksekusi web service dan menyimpannya dalam variabel
    $wsReturn = curl_exec($wsUrl);
    curl_close($wsUrl);
    // </editor-fold>
}
// </editor-fold>
?>

<form action="" method="post">
    <fieldset>
        <legend>Category Form</legend>
        <label for="idTxtCatName">Category name</label>
        <input id="idTxtCatName" name="txtCatName" type="text" autofocus="" placeholder="New Category Name" required="">
        <br>
        <input type="submit" name="btnSubmit" value="Submit Data" class="button button-primary">
        <input type="reset" value="Reset Form" class="button">
    </fieldset>
</form>

<table id="tableId" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = array('api_key' => '123');
// <editor-fold defaultstate="collapsed" desc="Get all data from web service. Can be replace with $wsReturn = Utility::curl_get('http://localhost/pw2_w09_ws/service/category/all/', $data)">
        $wsUrl = curl_init('http://localhost/pw2_w09_ws/service/category/all/' . http_build_query($data));
        curl_setopt($wsUrl, CURLOPT_RETURNTRANSFER, TRUE);
        $wsReturn = curl_exec($wsUrl);
        curl_close($wsUrl);
// </editor-fold>

        $result = json_decode($wsReturn);
        foreach ($result as $category) {
            echo '<tr>';
            echo '<td>' . $category->id . '</td>';
            echo '<td>' . $category->name . '</td>';
            echo '<td>' . '<button onclick="sendToUpdate(\'' . $category->id . '\');"><img src="images/row_edit.png" alt="Update Image"></button>'
            . ' '
            . '<button onclick="sendToDelete(\'' . $category->id . '\');"><img src="images/row_delete.png" alt="Delete Image"></button>' . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>