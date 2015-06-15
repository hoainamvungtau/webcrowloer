<?php
include("function/simple_html_dom.php");
$crawled_urls=array();
$found_urls=array();
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
                        <input type="text" name="website" value="" class="form-control" placeholder="input your website" name="txtwebsite">
                    </div>
                </div>
                <!--end div form-group-->

                <div class="form-group">
                    <label class="control-label col-xs-2">Your text</label>
                    <div class="col-xs-5">
                        <input type="text" name="text" value="the gioi" class="form-control" placeholder="input your text" name="txttext">
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
function rel2abs($rel, $base){
 if (parse_url($rel, PHP_URL_SCHEME) != ''){
  return $rel;
 }
 if ($rel[0]=='#' || $rel[0]=='?'){
  return $base.$rel;
 }
 extract(parse_url($base));
 $path = preg_replace('#/[^/]*$#', '', $path);
 if ($rel[0] == '/'){
  $path = '';
 }
 $abs = "$host$path/$rel";
 $re = array('#(/.?/)#', '#/(?!..)[^/]+/../#');
 for($n=1; $n>0;$abs=preg_replace($re,'/', $abs,-1,$n)){}
 $abs=str_replace("../","",$abs);
 return $scheme.'://'.$abs;
} 
function perfect_url($u,$b){
 $bp=parse_url($b);
   if(($bp['path']!="/" && $bp['path']!="") || $bp['path']==''){
    if($bp['scheme']==""){
     $scheme="http";
    }else{
     $scheme=$bp['scheme'];
    }
    $b=$scheme."://".$bp['host']."/";
   }
   if(substr($u,0,2)=="//"){
    $u="http:".$u;
   }
   if(substr($u,0,4)!="http"){
    $u=rel2abs($u,$b);
   }
  return $u;
}

function crawl_site($u,$text){
 global $crawled_urls, $found_urls;
 $uen=urlencode($u);
 if((array_key_exists($uen,$crawled_urls)==0 || $crawled_urls[$uen] < date("YmdHis",strtotime('-25 seconds', time())))){
  $html = file_get_html($u);
  $crawled_urls[$uen]=date("YmdHis");
  foreach($html->find("a") as $li){
      $url=perfect_url($li->href,$u);
      $enurl=urlencode($url);
      if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java" && array_key_exists($enurl,$found_urls)==0){
        $found_urls[$enurl]=1;
        echo $url."<br/>";
      }
  }
 }
 die;
}

if(isset($_POST['submit'])){
    $url=$_POST['website'];
    $text = $_POST['text'];
    if($url==''){
     echo "<h2>A valid URL please.</h2>";
    }else{
     echo "<h2>Result - URL's Found</h2><ul style='word-wrap: break-word;width: 100%;line-height: 25px;'>";
     crawl_site($url,$text);
     echo "</ul>";
    }
   }

?>



    </div>
</div>

</body>
</html>