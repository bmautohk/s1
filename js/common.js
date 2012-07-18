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
