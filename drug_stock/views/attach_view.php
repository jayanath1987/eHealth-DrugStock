 <html>
    <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <title>Attachment</title>
	 <?php 
		echo "<link rel='icon' type='image/ico' href='". base_url()."images/mds-icon.png'>";
		echo "<link rel='shortcut icon' href='". base_url()."images/mds-icon.png'>";


		echo "<script type='text/javascript' src='".base_url()."/js/jquery.js' ></script>";
	?>
	</head>	
  <body style='background:#aaaaaa;'>
  <table border=1 bordercolor='#000000' width=100% height=90% style='background:#555555;font-family:Arial;color:#F1F2F2;'>
  <tr><td colspan=2 id='file' style='font-size:14;'><b>HHIMS Attachment<b></td></tr>
                  <?php
      if($attach["Attach_Format"]=='application/pdf'){
      echo "<tr><td width=70% height=100% id='info'><iframe width=100% height=100% src='data:application/pdf;base64,".base64_encode($attach['Attach_File'])." '>";
      }
      else {
       echo "<tr><td width=70% height=100% id='info'><iframe width=100% height=100% src='data:image/jpeg;base64,".base64_encode($attach['Attach_File'])." '>";   
      }
  echo "</iframe>";
                          
 echo "</td>";
                      
                      ?>


  </table>

  </body>
  </html>