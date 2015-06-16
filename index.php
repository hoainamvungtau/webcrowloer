<?php
include("function/simple_html_dom.php");
$url = '';$text = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bootstrap 3 Typography</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/bootstrap-theme.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style type="text/css">
        .example{
            padding: 10px;
        }
    </style>
<script type="text/javascript">
$(document).ready(function(){
});
</script>
</head>
<body>
<div class="example">
    <div class="container">
        <div class="row">
            <h1>Index</h1>    
            <form class="form-horizontal" method="post" action="index.php">
                <div class="form-group">
                    <label class="control-label col-xs-2">Website url</label>
                    <div class="col-xs-5">
                        <input type="text" value="<?php echo $url; ?>" class="form-control" placeholder="input your website" name="txtwebsite">
                    </div>
                </div>
                <!--end div form-group-->

                <div class="form-group">
                    <label class="control-label col-xs-2">Your text</label>
                    <div class="col-xs-5">
                        <input type="text" value="<?php echo $text; ?>" class="form-control" placeholder="input your text" name="txttext">
                    </div>
                </div>
                <!--end div form-group-->

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <input type="submit" name="submit" class="btn btn-primary" value="Click me">
                    </div>
                </div>
            </form>
        </div>

<?php 

if(isset($_POST['submit'])){
    $url=$_POST['txtwebsite'];
    $text = $_POST['txttext'];
    if( $url =='' ){
     echo "<h2>A valid URL please.</h2>";
    }else{
     echo "<h2>Result - URL's Found</h2>";
     echo "<div class='table'>";
     echo "<table class='table table-border'>";
     $html = file_get_html($url);
     foreach ($html->find("div[class='title_news']") as $div) {
       foreach ($div->find('a') as $link) {
         echo "<tr class='active'><td>".$link->href."</td></tr>";
       }
     }
    }
   }

?>
    </div>
</div>

</body>
</html>