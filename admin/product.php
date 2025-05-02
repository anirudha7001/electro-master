<?php
  require('top.inc.php');
if(isset($_GET['type']) && $_GET['type']!=''){
  $type = $_GET['type'];
  if($type=='status'){
  $operation = $_GET['operation'];
  $id = $_GET['id'];
  if($operation=='active'){
    $status = '1';
  }else{
    $status = '0';
  }
  $update_status="update product set status='$status' where id='$id'";
  $conn->query($update_status);
  }

  if($type=='delete'){
  $id = $_GET['id'];
  $delete_sql="delete from product where id='$id'";
  $conn->query($delete_sql);
  }
  if($type=='edit'){
    $id = $_GET['id'];
$loc = 'location:manage_product.php?id='.$id;
    header($loc);
    die();
  }
  }
$sql = "select product.*,categories.categories from product,categories where product.categories_id=categories.id order by id asc";
$res= $conn->query($sql);
 
?>
         <div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Product</h4>
                           <h4 class="box-link"><a href="manage_product.php">Add Product</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th>ID</th>
                                       <th>Categories</th>
                                       <th>Name</th>
                                       <th>Image</th>
                                       <th>MRP</th>
                                       <th>Price</th>
                                       <th>Qty</th>
                                    </tr>
                                 </thead>
                                 <tbody>
<?php 
$i = 1;
while($row=mysqli_fetch_assoc($res)) {?>
<tr>
<td class="serial"><?php echo $i?></td>
<td><?php echo $row['id']?></td>
<td><?php echo $row['categories']?></td>
<td><?php echo $row['name']?></td>
<td><image src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"/></td>
<td><?php echo $row['mrp']?></td>
<td><?php echo $row['price']?></td>
<td><?php echo $row['qty']?></td>
<td><?php 
  if($row['status']==1){
    echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></span>&nbsp";
  }else{
    echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></span>&nbsp";
  }
  echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>&nbsp";
  echo "<span class='badge badge-edit'><a href='?type=edit&id=".$row['id']."'>Edit</a></span>&nbsp";
  //echo "<a href='?type=delete&id=".$row['id']."'>Delete</a>";
  //echo "&nbsp;<a href='?type=delete&id=".$row['id']."'>Edit</a>";
?></td>
</tr>
<?php }?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		  </div>

<?php
  require('footer.inc.php');
?>

