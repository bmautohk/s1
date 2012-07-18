
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

            <table width="506" border="0">

          <tr valign="top">

            <td width="500">No tracking no. JP<br>              

              <? getShipReport($group2, $user_name,'JP');; ?></td>

            </tr>

        </table>

</TD>

        </TR></TBODY></TABLE>

      <br>

      <br>

      <br></TD>
