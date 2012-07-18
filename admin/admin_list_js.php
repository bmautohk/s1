<SCRIPT>
	function confirmDelete(id, ask, url) //confirm order delete
	{
		temp = window.confirm(ask);
		if (temp) //delete
		{
			window.location=url+id;
		}
	}
	function open_window(link,w,h)
	{
		var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
		newWin = window.open(link,'newWin',win);
	}
</SCRIPT>
	<script Language="JavaScript" Type="text/javascript"><!--
function FrontPage_Form1_Validator(theForm)
{

  if (theForm.firstname.value == "")
  {
    alert("Please enter a value for the \"firstname\" field.");
    theForm.firstname.focus();
    return (false);
  }
  if (theForm.lastname.value == "")
  {
    alert("Please enter a value for the \"lastname\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.username.value == "")
  {
    alert("Please enter a value for the \"username\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.password.value == "")
  {
    alert("Please enter a value for the \"password\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (theForm.redirect.value == "")
  {
    alert("Please enter a value for the \"redirect\" field.");
    theForm.firstname.focus();
    return (false);
  }
}

function mod_user_Validator(modForm)
{

  if (modForm.username.value == "")
  {
    alert("Please enter a value for the \"username\" field.");
    theForm.firstname.focus();
    return (false);
  }
  if (modForm.modify.value == "")
  {
    alert("Please enter a value for the \"modify\" field.");
    theForm.firstname.focus();
    return (false);
  }
    if (modForm.change.value == "")
  {
    alert("Please enter a value for the \"change\" field.");
    theForm.firstname.focus();
    return (false);
  }
 }
//--></script>