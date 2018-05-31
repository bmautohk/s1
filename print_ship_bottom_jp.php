<?php



//prevents caching

header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

header("Cache-Control: post-check=0, pre-check=0",false);

session_cache_limiter();

session_start();



require('config.php');  //this should the the absolute path to the config.php file 

                                    //(ie /home/website/yourdomain/login/config.php or 

                                    //the location in relationship to the page being protected - ie ../login/config.php )

require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above



if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.

include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above

exit;

}

?>

<? $sale_ref = $_GET['sale_ref']; ?>



<html>

<head>

<? require ('header_script.php');?>

<title>Print Parcel</title>

<LINK href="style1.css" type=text/css rel=STYLESHEET>

<style type="text/css">

<!--

	.style2 {	font-size: 12px;
	
		font-weight: bold;
	
	}
	
	.small2 {
	
		FONT-SIZE: 9px
	
	}
	
	.style4 {font-size: 12; font-weight: bold; }
	
	.style5 {font-size: 12px}
	
	.style6 {font-size: 12px; font-weight: normal; }
	
	.style9 {font-size: 12; font-weight: bold; }
	
	.style11 {font-family: NW-7; font-size: 22px; font-weight: normal; }
	.style111 {font-family: NW-7; font-size: 22px; font-weight: normal; }
	
	body {
	
		margin-left: 0px;
	
		margin-top: 0px;
	
		margin-right: 0px;
	
		margin-bottom: 0px;
	
	}
	
	.container-top {
		height: 415px;
		overflow:hidden;
	}
	
	.container-bottom {
		height: 300px;
		overflow:hidden;
	}
	
	.delivery {
		FONT-SIZE: 11px;
		FONT-FAMILY: Tahoma;
		display:block;
	}
	
	.shipping_jp {
		FONT-SIZE: 12px;
		FONT-FAMILY: Tahoma;
	}

-->

</style>

<meta http-equiv="Content-Type" content="text/html; charset=euc-jp"></head>

<body>



	

	<?

	$debt_row=getdebt_data($sale_ref);

	$order_row=getsale_data($sale_ref);

	$ship_row=getship_data($sale_ref);
	
	$bal = getbalance_data($sale_ref);
	
	$prod_rows = getsprod_data_all($sale_ref);
	$office_addr=getOfficeAddress($addr_id);

	?>

    <br>

    <br>

<div style="width:905px">

<!-- Top left -->
    <div class="container-top" style="width:290px; float:left;">
    	<div style="height:310px; overflow:hidden; ">
			<table width="286" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top">

					<td width="286" class="style2">
						<div align="right">
							<span class="style6"> </span>
						</div>
						<div align="left">
							<span class="style4"><span class="style6">¢©<? echo "". $debt_row['debt_post_co'];?>
							</span> </span>
						</div>
					</td>

				</tr>

				<tr>

					<td class="style2"><span class="style2"></span> &nbsp;<? echo "". $debt_row['debt_cust_address1'];?>
					</td>

				</tr>

				<tr>

					<td class="style2 style4"><? echo "". $debt_row['debt_cust_address2'];?>
					</td>

				</tr>

				<tr>

					<td class="style2"><? echo "". $debt_row['debt_cust_address3'];?>
					</td>

				</tr>

				<tr>

					<td class="style2"><? echo "". $order_row['sale_name'];?> ÕÕ</td>

				</tr>

				<tr>

					<td align="left" class="style2">
						<span class="style6">
							<span class="style4">
								<? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {
									echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile']; 
								}?>
							</span>
						</span>
					</td>

				</tr>

				<tr style="vertical-align: top; height: 230px">

					<td class="style2">
						<span class="style6"><br></span>
						<span class="small2"><strong><?=$office_addr['address1']?><br> <?=$office_addr['address2']?><br>

								<?=$office_addr['address3']?> </strong> </span><span
						class="style5"><br> </span>
						
						<span class="style6"><br>
						
							<span class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?></span>
							<span class="small2">Group: <?=$order_row['sale_group']; ?>
	
									<br>
	
							</span>
							
							<span class="small2">
								&#21830;&#21697;&#21517;:
								<? foreach ($prod_rows as $prod_row) { ?>
									<?=$prod_row['sprod_name']; ?>
									<br />
									<?=$prod_row['sprod_material'] ?> <?=$prod_row['sprod_colour'] ?>
									<br />
									<br />
								<? } ?>
							</span>
							
						</span>
					</td>

				</tr>

			</table>
		</div>
		
		<div class="style6" style="height:40px; padding-left:2px;padding-top:10px; overflow:hidden;">
    		<span class="delivery" style="width:75px; float:left"><?=$bal['bal_delivery_date'] ?>&nbsp;</span>
			<span class="delivery"><?=$bal['bal_delivery_time'] ?>&nbsp;</span>
    	</div>

	</div>

<!-- Top middle -->
	<div class="container-top" style="width: 302px; float:left">
    	<div style="height:260px; overflow:hidden;">
    		<table border="0" cellspacing="0" cellpadding="0">
				<tr>

					<td class="style2">&nbsp;</td>

					<td colspan="4" class="style2"><table width="100%" border="0">
							<tr>
								<td><font size="16" class="style9"><strong>Œ¡∂‚∏Â«º</strong> </font>
								</td>
								<td><span class="style6">&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
										&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;a<? echo "". $ship_row['check_shipping_jp'];?>a
								</span>&nbsp; &nbsp; &nbsp;</td>
							</tr>
						</table>
					</td>

				</tr>
				<tr>
					<td height="30"></td>
				</tr>
				<tr>

					<td width="11" class="style2">

						<div align="left"></div>
					</td>

					<td colspan="4" class="style2"><span class="style4"><span
							class="style6">¢©<? echo "". $debt_row['debt_post_co'];?>
						</span> </span></td>

				</tr>

				<tr>

					<td class="style2">&nbsp;</td>

					<td height="18" colspan="4" valign="top" class="style2"><span
						class="style4"><? echo "". $debt_row['debt_cust_address1'];?> </span>
					</td>

				</tr>

				<tr>

					<td class="style2 style5">&nbsp;</td>

					<td colspan="4" class="style2"><span class="style4"><? echo "". $debt_row['debt_cust_address2'];?>
					</span></td>

				</tr>

				<tr>

					<td class="style2">&nbsp;</td>

					<td colspan="4" class="style2 style4"><span class="style4"><? echo "". $debt_row['debt_cust_address3'];?>
					</span></td>

				</tr>

				<tr>

					<td align="right" class="style2">&nbsp;</td>

					<td colspan="4" class="style2"><span class="style4"><? echo "". $order_row['sale_name'];?>
							ÕÕ</span></td>

				</tr>

				<tr>

					<td width="11" class="style2">&nbsp;</td>

					<td colspan="4" class="style2"><span class="style6"><span
							class="style4"> <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>

						</span> </span></td>

				</tr>

				<tr>

					<td colspan="5" class="style2">&nbsp;</td>

				</tr>

				<tr>

					<td class="style4"><em> <br> <br>

					</em></td>

					<td height="101" colspan="4" valign="top" class="style6"><span
						class="small2"><?=$office_addr['address1']?><br> <?=$office_addr['address2']?><br>

							<?=$office_addr['address3']?><br> °°</span><br> <span
						class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?>
					</span> <span class="small2">Group: <?=$order_row['sale_group']; ?>
							<!--<br>--->
					</span> <br />
					<span class="small2"> &#21830;&#21697;&#21517;:
						<? foreach ($prod_rows as $prod_row) { ?>
							<?=$prod_row['sprod_name']; ?><br />
						<? } ?>
					</span>
					</td>

				</tr>

				<tr>

					<td colspan="5" class="style2"></td>

				</tr>

			</table>
    	
    	</div>
    	
    	<div>
    		<table>
    			<tr>
					<td colspan="2">&nbsp;</td>

					<td width="178">
						<div align="right">
							<span class="style6"><? echo "". $ship_row['check_shipping_jp'];?>
							</span>&nbsp;
						</div>
					</td>

					<td colspan="2">&nbsp;</td>

				</tr>

				<tr>

					<td><em></font> </em></td>

					<td colspan="3" align="center" valign="middle"><span
						class="style111">a<? echo "". $ship_row['check_shipping_jp'];?>a
					</span><br> <span class="style6">a<? echo "". $ship_row['check_shipping_jp'];?>a
					</span> <br>
					</td>

					<td width="83">&nbsp;</td>

				</tr>
    		</table>
    	</div>
	</div>
	
<!-- Top right -->
    <div class="container-top" style="width:300px;">
    	<div class="delivery" style="height:245px; margin:50px 0px 0px 20px; overflow:hidden;">
    		<? foreach ($prod_rows as $prod_row) { ?>
    			<?=$prod_row['sprod_colour'] ?><br />
    		<? } ?>
    	
    		<br />
			<? echo "".$debt_row['debt_remark'];?>
    		<?=$bal['bal_delivery_date'] ?>
    		<?=$bal['bal_delivery_time'] ?>
    	</div>
    </div>
	
<!-- Bottom left -->
	<div class="container-bottom" style="width:290px; float:left;">
    	<div style="height:235px; overflow:hidden;">
    	
    		<table width="286" border="0" cellspacing="0" cellpadding="0">
				<tr>

					<td colspan="2" class="style6">

						<div align="left"></div>
						<span class="style9">¢©<? echo "". $debt_row['debt_post_co'];?></span>
					</td>

				</tr>

				<tr>

					<td height="18" colspan="2" class="style6">
						<span class="style9"><? echo "". $debt_row['debt_cust_address1'];?></span>
					</td>

				</tr>

				<tr>

					<td colspan="2" class="style2 style5"><span class="style9"><? echo "". $debt_row['debt_cust_address2'];?>
					</span></td>

				</tr>

				<tr>

					<td colspan="2" class="style6"><span class="style9"><? echo "". $debt_row['debt_cust_address3'];?>
					</span></td>

				</tr>

				<tr>

					<td colspan="2" align="right" class="style6">
						<div align="left">
							<span class="style9"><? echo "". $order_row['sale_name'];?> ÕÕ</span>
						</div>
					</td>

				</tr>

				<tr>

					<td colspan="2" class="style6"><span class="style9"> <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>

					</span></td>

				</tr>

				<tr>

					<td colspan="2" class="style6">&nbsp;</td>

				</tr>

				<tr align="left" valign="top">

					<td height="150" colspan="2" class="style9"><em> </em><span
						class="small2"><?=$office_addr['address1']?><br> <?=$office_addr['address2']?><br>

							<?=$office_addr['address3']?> </span><br> <br> <span
						class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?>
					</span> <span class="small2">Group: <?=$order_row['sale_group']; ?>
					</span> <br />
					<span class="small2"> &#21830;&#21697;&#21517;:
						<? foreach ($prod_rows as $prod_row) { ?>
							<?=$prod_row['sprod_name']; ?><br />
						<? } ?>
					</span>
					</td>

				</tr>

			</table>
    	</div>
   	
   		<div style="height:40px; overflow:hidden;">
   			<table>
   				<tr>
   					<td width="204" height="15">
						<div align="center">
							<span class="style11">a<? echo "". $ship_row['check_shipping_jp'];?>a</span>
							<span class="style6">a<? echo "". $ship_row['check_shipping_jp'];?>a</span>
						</div>
					</td>
   				</tr>
   			</table>
   		</div>
   		
    </div>
    
<!-- Bottom middle -->
    <div class="container-bottom" style="width:305px; margin-right:5px; float:left;">
    	<div style="height:235px; overflow:hidden;">
    		<table width="300" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td width="10" class="style6">

						<div align="left"></div>
					</td>

					<td colspan="3" class="style6"><span class="style9">¢©<? echo "". $debt_row['debt_post_co'];?>
					</span></td>

				</tr>

				<tr>

					<td class="style6">&nbsp;</td>

					<td height="18" colspan="3" valign="top" class="style6"><span
						class="style9"><? echo "". $debt_row['debt_cust_address1'];?> </span>
					</td>

				</tr>

				<tr>

					<td class="style2 style5">&nbsp;</td>

					<td colspan="3" class="style6"><span class="style9"><? echo "". $debt_row['debt_cust_address2'];?>
					</span></td>

				</tr>

				<tr>

					<td class="style6">&nbsp;</td>

					<td colspan="3" class="style2 style4"><span class="style9"><? echo "". $debt_row['debt_cust_address3'];?>
					</span></td>

				</tr>

				<tr>

					<td align="right" class="style6">&nbsp;</td>

					<td colspan="3" class="style6"><span class="style9"><? echo "". $order_row['sale_name'];?>
							ÕÕ</span></td>

				</tr>

				<tr>

					<td width="10" class="style6">&nbsp;</td>

					<td colspan="3" class="style6"><span class="style9"> <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>

					</span></td>

				</tr>

				<tr>

					<td colspan="4" class="style6">&nbsp;</td>

				</tr>

				<tr>

					<td width="10" class="style9"><em> <br> <br>

					</em></td>

					<td height="140" colspan="3" valign="top" class="style6"><span
						class="small2"><?=$office_addr['address1']?><br> <?=$office_addr['address2']?><br>

							<?=$office_addr['address3']?> </span><br> <br> <span
						class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?>
					</span> <span class="small2">Group: <?=$order_row['sale_group']; ?>
					</span> <br />
					
					<span class="small2"> &#21830;&#21697;&#21517;:
						<? foreach ($prod_rows as $prod_row) { ?>
							<?=$prod_row['sprod_name']; ?><br />
						<? } ?>
					</span>
					</td>

				</tr>

				<tr>
					<td colspan="4">
						<table>
							<tr style="vertical-align: top">
								
							</tr>
						</table>
					</td>
				</tr>

				<tr>

					<td colspan="4" class="style6"></td>

				</tr>

			</table>
    	</div>
    	
    	<div class="style6" style="height:20px; overflow:hidden;">
			<span class="delivery" >
				<?
				$isFirst = true;
				foreach ($prod_rows as $prod_row) {
					if ($isFirst) {
						$isFirst = false;
						echo $prod_row['sprod_material'];
					} else {
						echo ", ".$prod_row['sprod_material'];
					}
				} ?>
			</span>
    	</div>
    	
    	<div style="height:40px; overflow:hidden;">
    		<span class="style9 shipping_jp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<? echo "". $ship_row['check_shipping_jp'];?>
							</span>
    		</table>
    	</div>
    	
    </div>
    
<!-- Bottom right -->
    <div class="container-bottom" style="width:300px;">
    	<div style="height:235px; overflow:hidden;">
    		<table width="300" border="0" cellspacing="0"
				cellpadding="0">

				<tr>

					<td width="10" class="style6">

						<div align="left"></div>
					</td>

					<td colspan="3" class="style6"><span class="style9">¢©<? echo "". $debt_row['debt_post_co'];?>
					</span></td>

				</tr>

				<tr>

					<td class="style6">&nbsp;</td>

					<td height="18" colspan="3" valign="top" class="style6"><span
						class="style9"><? echo "". $debt_row['debt_cust_address1'];?> </span>
					</td>

				</tr>

				<tr>

					<td class="style2 style5">&nbsp;</td>

					<td colspan="3" class="style6"><span class="style9"><? echo "". $debt_row['debt_cust_address2'];?>
					</span></td>

				</tr>

				<tr>

					<td class="style6">&nbsp;</td>

					<td colspan="3" class="style2 style4"><span class="style9"><? echo "". $debt_row['debt_cust_address3'];?>
					</span></td>

				</tr>

				<tr>

					<td align="right" class="style6">&nbsp;</td>

					<td colspan="3" class="style6"><span class="style9"><? echo "". $order_row['sale_name'];?>
							ÕÕ</span></td>

				</tr>

				<tr>

					<td width="10" class="style6">&nbsp;</td>

					<td colspan="3" class="style6"><span class="style9"> <? if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') {echo "Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];}?>

					</span></td>

				</tr>

				<tr>

					<td colspan="4" class="style6">&nbsp;</td>

				</tr>

				<tr>

					<td width="10" class="style9"><em> <br> <br>

					</em></td>

					<td height="140" colspan="3" valign="top" class="style6"><span
						class="small2"><?=$office_addr['address1']?><br> <?=$office_addr['address2']?><br>

							<?=$office_addr['address3']?> </span><br> <br> <span
						class="small2">æ¶… ID: <? echo getsprod_ship_data($sale_ref); ?>
					</span> <span class="small2">Group: <?=$order_row['sale_group']; ?>
					</span> <br />
					<span class="small2"> &#21830;&#21697;&#21517;:
						<? foreach ($prod_rows as $prod_row) { ?>
							<?=$prod_row['sprod_name']; ?><br />
						<? } ?>
					</span>
					</td>

				</tr>

			</table>
    	</div>
    	
    	<div class="style6" style="height:20px; overflow:hidden;">
			<span class="delivery" >
				<?
				$isFirst = true;
				foreach ($prod_rows as $prod_row) {
					if ($isFirst) {
						$isFirst = false;
						echo $prod_row['sprod_material'];
					} else {
						echo ", ".$prod_row['sprod_material'];
					}
				} ?>
			</span>
    	</div>
    	
    	<div class="style6" style="height:40px; overflow:hidden;">
    		<span class="style9 shipping_jp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <? echo "". $ship_row['check_shipping_jp'];?></span>
    	</div>
    	
    </div>
    
</div>

</body>

</html>

