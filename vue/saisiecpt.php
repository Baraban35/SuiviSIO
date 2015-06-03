<?php  include_once 'exit.php';
?>
<div id="corps">
<h2>Saisie 
<?php
  $t=$data["t"];
  if ($t=="r") echo "rapport";
  if ($t=="b") echo "bilan";
  $e=$data["e"];
  
?>
</h2>




<script type="text/javascript" src="mce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		language : "fr",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>


<form method="post" action="index.php">
  <input type="hidden" name="action" value="stage">
	<?php
	    $iddoc=$data["iddoc"];
	    echo '<input type="hidden" name="t" value="'.$t.'">';
	    echo '<input type="hidden" name="e" value="'.$e.'">';

	    if ($iddoc!=0){
	      $titre=$data["doc"]["titre"];
	      $cont=$data["doc"]["cont"];
	    } else {
	      $titre="";
	      $cont="";
	    }
      echo '<input type="hidden" name="iddoc" value="'.$iddoc.'">';

      echo '<p>Titre : <input type="text" name="titre" size="60"
            maxlength="80" value="'.$titre.'"></p>';

	    echo '<textarea id="el" name="el" rows="20" cols="80" 
            style="width: 90%">'.$cont.'</textarea>';

  ?>
	<br />
	<input type="submit" name="sauve" value="Enregistrer" />

</form>


       </div>
