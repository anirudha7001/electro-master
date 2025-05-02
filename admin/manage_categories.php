<?php
require('top.inc.php');
$cate = '';
if(isset($_GET['id']) && $_GET['id']!=''){
  $id=$_GET['id'];
  $res=$conn->query("select * from categories where id='$id'");
  $row = $res->fetch_assoc();
  echo '<h1>'.$row['categories'].'</h1>';
  $cate = $row['categories'];
}
 
if(isset($_POST['submit'])){
  $cate =$_POST['categories'];
  if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
    $conn->query("update categories set categories='$cate' where id=$id");
  }else{
  try{
  $conn -> query("insert into categories(categories,status) values('$cate','1')");
  }
  catch(Exception $e){
    echo 'Message: '.$e->getMessage();
  }
  }
  header('location:categories.php');
  die();
}

?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                        <form method="post">
                        <div class="card-body card-block">
                        <div class="form-group"><label for="company" class=" form-control-label">Categories</label><input name="categories" type="text" id="company" placeholder="Enter your categories name" value="<?php echo $cate ;?>" class="form-control" required></div>
                           <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
</div>
<?php
require('footer.inc.php');
?>
