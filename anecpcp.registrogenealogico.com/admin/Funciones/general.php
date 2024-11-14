<?










function xpaginador($reg,$ini,$fin,$filas)
{
			$numrows=$filas;
			if(sizeof($reg) >(int)$fin)
			  {

			    if($ini==1)
				{
				///adelante
				$ini=1;$fin=$numrows;
				$neoinicio=$fin+1;
				$neofin=$fin+$numrows;

				echo"<tr><td colspan=9 align=center><a href='javascript:next(".$neoinicio.",".$neofin.");' >P&aacute;gina siguiente  <img src='img/b_nextpage.png' border=0></a>&nbsp;&nbsp;";
  	  			echo"</td></tr>";
				}
			    else
				{
				///adelante
				$neoinicio=$fin+1;
				$neofin=$fin+$numrows;

				////atras
				$backinicio=$neoinicio-$numrows-$numrows;
				$backfin=$neofin-$numrows-$numrows;

			        echo"<tr><td colspan=9 align=center  class='text2'><a href='javascript:next(".$backinicio.",".$backfin.");' ><img src='img/b_prevpage.png' alt='anterior' border=0></a>&nbsp;&nbsp;P&aacute;ginas&nbsp;&nbsp;<a href='javascript:next(".$neoinicio.",".$neofin.");' >  <img src='img/b_nextpage.png' alt='siguiente ' border=0></a>&nbsp;&nbsp;";
  			        echo"</td></tr>";
				}

			   	
			  }
			  
		       elseif(sizeof($reg)<=(int)$fin)
				{
		
			     	$inix=$fin-$numrows-$numrows;
				$ini=$inix+1;
			   	$fin=$inix+$numrows;
				if($ini<0)
				{
				echo"<tr><td colspan=9 align=center>&nbsp;&nbsp;";    echo"</td></tr>";
				}
				else
				{
				echo"<tr><td colspan=9  align=center><a href='javascript:next(".$ini.",".$fin.");' > <img src='img/b_prevpage.png' border=0>&nbsp;&nbsp; Volver </a>&nbsp;&nbsp;";
  	  			echo"</td></tr>";
				}
				

				}
				else
				{
					     echo"<tr><td colspan=9 align=center>&nbsp;&nbsp;";    echo"</td></tr>";
				}	



}


?>