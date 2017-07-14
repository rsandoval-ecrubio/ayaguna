<?php  
mysql_connect("localhost","appstc","nVgXi3HT40"); 
mysql_select_db("appstc_ayaguna_jmp"); 
$firstQry         = "select * from  fact_bancos";      // table 1 
$firstQry2 = mysql_query($firstQry);
  $row = mysql_fetch_assoc($firstQry2);

?> 
<form name="dummy" id="dummy"> 
    <!-- First DropDown starts here --> 
        <select name="first" onchange="document.forms['dummy'].elements['txt'].value = document.forms['dummy'].elements['first'].value"> 
            <?php while($res        =      mysql_fetch_array($firstQry)){?> 
                <option  value="<?php echo $res["id"]?>"><?php echo $res["banco"]?></option> 
            <?php }unset($firstQry,$res);?> 
      
        </select>
  <input type="text" name="txt" id="txt" onblur="This.value=formulario.campo.value;" />  
        </form>
<form name="form1" method="post" action="">
<!--
  <p>
    <label for="texto1"></label>
    <input name="texto1" type="text" id="texto1" value="10" Onchange="form1.texto2.value=this.value"
>
  </p>
  -->
  <p>
    <select name="select" id="select" Onchange="form1.texto2.value=this.value">
    <option>VALOR</option>
    <?php do { ?>
    <option value="<?php echo $row['id']; ?>"><?php echo $row['banco']; ?></option>
    <?php } while ($row = mysql_fetch_assoc($firstQry2)); ?>
    </select>
  </p>
  <p>
    <input name="texto2" type="text" id="texto2">
  </p>
</form>
<p>&nbsp;</p>
