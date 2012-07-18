
          <TD vAlign=top bgColor=#eefafc>


            <table width="777" border="0" cellspacing="10">

              <tr>

                <td><p>

                    <FORM method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">

                    <input type="hidden" name="page" value="<?=$page?>" />
                    <input type="hidden" name="subpage" value="<?=$subpage?>" />

                      <table width="406" border="0">

                        <tr>

                          <td width="30">From</td>

                          <td width="100"><script>DateInput('date_start', true, 'YYYY-MM-DD')</script>

              &nbsp;</td>

                          <td width="16">To </td>

                          <td width="84"><script>DateInput('date_end', true, 'YYYY-MM-DD')</script>

              &nbsp;</td>

                        </tr>

                      </table>

                      <br>

                      <input name="Submit" type="submit" value="Check Record">

                    </FORM>

                    <p></p>

                </td>

              </tr>

            </table>

            <br>

            <br>

            <br>

            <table width="614" border="0">

          <tr valign="top">

            <td width="608">With tracking no. <br>            
              
            <?  

 if (!isset($_GET['date_start']) and !isset($_GET['date_end']) )

{

$today = date("Y-m-d"); 

$today_10 = date("Y-m-d", mktime(0,0,0,date("m"),date("d")-60,date("Y")));

getShipReport2($today_10,$today,$group2, $user_name);

}

else

{getShipReport2($_GET['date_start'],$_GET['date_end'],$group2, $user_name);

} ?></td>

          </tr>

        </table>

</TD>

        </TR></TBODY></TABLE>

      <br>

      <br>

      <br></TD>
