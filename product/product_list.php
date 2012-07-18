
          <TD vAlign=top bgColor=#eefafc>
            <p>
              <?

	
	@$product_name=$_POST['product_name'];
	@$product_id=$_POST['product_id'];
	$product_photo=$product_id;

	
?>
              <? //echo"<form action='addData.php?update=".$update."&info=data' method='POST' name='form1' enctype='multipart/form-data'>"; ?></p>
            <table width="939" height="24" border="0" cellpadding="0" cellspacing="0">
              <tr valign="middle">
                <td height="24" align="center">
				
				<br>
				Page <?  
				if (isset ($_GET['prod_order']))
				{$prod_order = $_GET['prod_order'];}
				else
				{$prod_order = "product_id";}
				
				//display code
$zpage=$_GET['zpage'];

$db=connectDatabase();

mysql_select_db(DB_NAME,$db);


    $per_page = 30; 

    $sql_text = "SELECT * FROM product order by product_id DESC"; 

    // Set page #, if no page isspecified, a
				    //     ssume page 1 

    if (!$zpage) { 
    $zpage = 1; 
    } 
    $prev_page = $zpage - 1; 
    $next_page = $zpage + 1; 
    $query = mysql_query($sql_text,$db);
    // Set up specified page 
    $page_start = ($per_page * $zpage) - $per_page; 
    $num_rows = mysql_num_rows($query); 
    if ($num_rows <= $per_page) { 
    $num_pages = 1; 
    } else if (($num_rows % $per_page) == 0) { 
    $num_pages = ($num_rows / $per_page); 
    } else { 
    $num_pages = ($num_rows / $per_page) + 1; 
    } 
    $num_pages = (int) $num_pages; 
    if (($zpage > $num_pages) || ($zpage < 0)) { 
    error("You have specified an invalid page number"); 
    } 
    // 
    // Now the pages are set right, we can 
    // perform the actual displaying... 
    if ($prev_page) {
    echo "<a href=\"$PHP_SELF?page=$page&subpage=$subpage&zpage=$prev_page\">Prev</a>";
    }
    // Page # direct links 
    // If you don't want direct links to eac
    //     h page, you should be able to
    // safely remove this chunk.
    for ($i = 1; $i <= $num_pages; $i++) { 
    if ($i != $zpage) { 
    echo " <a href=\"$PHP_SELF?page=$page&subpage=$subpage&zpage=$i\">$i</a> "; 
    } else { 
    echo " $i "; 
    } 
    } 
    // Next 
    if ($zpage != $num_pages) { 
    echo "<a href=\"$PHP_SELF?page=$page&subpage=$subpage&zpage=$next_page\">Next</a> ";
    }
				?>
                <br>
                <br>                  
                <form name="form1" method="post" action="<?= $_SERVER['PHP_SELF']; ?>?page=<?=$page?>&subpage=<?=$subpage?>">
                  <table width="1046" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr align="center" valign="top">
                      <td width="61" height="30"><div align="center">Product ID</div></td>
                      <td width="87"><div align="center">Product Name </div></td>
                      <td width="82"><div align="center">Photo</div></td>
                      <td width="74"><div align="center">Modify<br> 
                        (+/-) </div></td>
					  <td width="63"><div align="center">Modify JP<br>
					    (+/-) </div></td>
                      <td width="67">Real Stock PCS</td>
					  <td width="54">JP </td>
                      <td width="78">PCS-ORDER</td>
                      <td width="47">Color</td>
                      <td width="62">Price (Users)</td>
                      <td width="68">Price (Supplier) </td>
                      <td width="68">Cost (RMB) </td>
                      <td width="69">Catogery</td>
                      <td width="22">Web</td>
                      <td width="47"><div align="center">Dit</div></td>
                      <td width="57">Loc.</td>
                      <td width="74"><div align="center">Delete</div></td>
                    </tr>
                    <tr valign="top">
                      <td height="25">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><div align="center">&nbsp; </div></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
					  <td>&nbsp;</td>
					   <td>&nbsp;</td>
                    </tr>
                    <?
   
    getprodList($prod_order,$page_start, $per_page);
 

   
				?>
                  </table>
                  <br>
                  <br>
				  <input name="pro_order" type="hidden" value="<?=$prod_order; ?>">
				  <input name="page_start" type="hidden" value="<?=$page_start; ?>">
                  <input name="per_page" type="hidden" value="<?=$per_page; ?>">
				  
			      <input type="submit" name="Submit" value="Submit">
                </form>
                <div align="center"><br>
				  
				
				    </div></td>
                </tr>
            </table>
            <p>&nbsp;</p></TD>
