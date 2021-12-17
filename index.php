<?php
$question = 'این یک پرسش نمونه است';
$msg = 'این یک پاسخ نمونه است';
$en_name = 'hafez';
$fa_name = 'حافظ';



$result=file_get_contents("people.json");
$_array=json_decode($result);
$question = '';
$msg = 'سوال خود را بپرس!';



$result=file_get_contents("people.json");
$json_object=json_decode($result,True);  



if(isset($_POST['submit']))
{
    $question=$_POST["question"];
    $en_name=$_POST["person"];
    $hashed=hash('sha256',$question.$en_name);
    $int_hashed=intval($hashed);



    $responseArray=array();
    $messageFile=fopen("messages.txt","r");
    while(!feof($messageFile))
    {
        $line = fgets($messageFile);
        array_push($responseArray,$line);
    }
    fclose($messageFile);
    $msg=$responseArray[($int_hashed%count($responseArray))];



    if(!(substr($question,0,6)=="آیا" && (substr($question, -1, 1)=='?' || substr($question, -2, 2)=='؟')))
    {
        $msg="سوال درستی پرسیده نشده";
    }
    
    
}
else 
{
    $random_key=array_rand($json_object);
    $en_name=$random_key;
}        

foreach($json_object as $key => $value)
{
    if($key==$en_name)
    {
        $fa_name=$value;
    }
}




///////////////////
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <?php
        if(isset($_POST['submit']))
            echo "<span id='label'>پرسش:</span>";
        ?>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form action="" method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                /*
                 * Loop over people data and
                 * enter data inside `option` tag.
                 * E.g., <option value="hafez">حافظ</option>
                 * 
                 * 
                 */

                $result=file_get_contents("people.json");
                $json_object=json_decode($result);             
                foreach($json_object as $key => $val)
                {
                    if($key==$en_name)
                    echo "<option value='$key' selected='selected'>" . $val . "</option>";
                    else
                    echo "<option value='$key'>" . $val . "</option>";
                }

                ?>
            </select>
            <input type="submit" name="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>