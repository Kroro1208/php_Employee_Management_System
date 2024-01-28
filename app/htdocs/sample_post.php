<?php
echo "通信方式は" . $_SERVER['REQUEST_METHOD'] . "です" . "<br>";
echo "IDは" .  $_POST['user_id'] . "です" . "<br>";
echo "パスワードは" . $_POST["password"] . "です" . "<br>";
echo "お問い合わせ内容:" . $_POST["question"] . "<br>";
echo "Yes or No:" . $_POST["yes_no"] . "<br>";
echo "出身地は:" . $_POST["pref"] . "です";
echo "好きなフルーツは:";
foreach ($_POST["fruits"] as $fruit) {
    echo $fruit . " ";
}
echo "です";


?>

<form action="sample_post.php" method="POST">
    ユーザーID: <input type="text" name="user_id"><br>
    パスワード: <input type="password" name="password"><br>
    お問い合わせ: <textarea name="question" cols="30" rows="5"></textarea><br>
    <input type="radio" name="yes_no" value="Yes">はい
    <input type="radio" name="yes_no" value="No">いいえ<br>
    <select name="pref">
        <option value="">出身都道府県を選択してください</option>
        <option value="北海道">北海道</option>
        <option value="青森県">青森県</option>
        <option value="岩手県">岩手県</option>
        <option value="福岡県">福岡県</option>
        <option value="佐賀県">佐賀県</option>
        <option value="長崎県">長崎県</option>
        <option value="熊本県">熊本県</option>
        <option value="大分県">大分県</option>
        <option value="宮崎県">宮崎県</option>
        <option value="鹿児島県">鹿児島県</option>
        <option value="沖縄県">沖縄県</option>
    </select>
    <p>好きなフルーツを選択してください</p>
    <input type="checkbox" name="fruits[]" value="apple">りんご
    <input type="checkbox" name="fruits[]" value="banana">バナナ
    <input type="checkbox" name="fruits[]" value="grape">ぶどう
    <input type="submit" value="送信">
</form>