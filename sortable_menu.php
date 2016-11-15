<?php
session_start();
if(!$_SESSION['Nombre'])
{
  header('Location: index.php');
}

include ("conexion.php");
$var = new conexion();
$var->conectarse();

include ("class_menu.php") ;
$menu= new menu();

$sql  = "SELECT * FROM  tbl_menu_emp where parent_id=0 order by orden asc, id_menu asc ";
$resultado = mysql_query($sql)or die(mysql_error());
require("header.php");
?>
<style type="text/css">

ol {
    text-align: left;
    counter-reset: li; /* Initiate a counter */
    list-style: none; /* Remove default numbering */
    *list-style: decimal; /* Keep using default numbering for IE6/7 */
    font: 15px 'trebuchet MS', 'lucida sans';
    padding: 0;
    margin-bottom: 4em;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

ol ol {
    margin: 0 0 0 3em; /* Add some left margin for inner lists */
}
.rounded-list div{
    position: relative;
    display: block;
    padding: .4em .4em .4em 2em;
    *padding: .4em;
    margin: .2em 0;
    background: #ddd;
    color: #444;
    text-decoration: none;
    border-radius: .3em;
    transition: all .3s ease-out;
}

.rounded-list div:hover{
    background: #eee;
}



.rounded-list div:hover:before{
    transform: rotate(360deg);
}

.rounded-list div:before{
    content: counter(li);
    counter-increment: li;
    position: absolute;
    left: -1.3em;
    top: 50%;
    margin-top: -1.3em;
    background: #87ceeb;
    height: 2em;
    width: 2em;
    line-height: 2em;
    border: .3em solid #fff;
    text-align: center;
    font-weight: bold;
    border-radius: 2em;
    transition: all .3s ease-out;
}

.rounded-list div.sub:before{
    background: #fa8072;
}


.rounded-list div.sub2:before{
    background: #ae81ff;
}

.rounded-list label.pull-right span {
    color: #000;
}

</style>
<br>
<form name="grupos" action="" method="post">
	<div class="container text-ce">

			<div id="menu" class="well">
				<div class="row">
					<div class="span6 offset2">
						<div class="page-header">
							<h2>Administrar Menu</h2>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="span12 text-left ">
                      <a href="principal.php" class="btn btn-danger">&nbsp;Atrás&nbsp;</a>
                      <a href="edit_menu.php" class="btn btn-success">Agregar</a>
                      <a href="demo_menu.php" class="btn btn-info">Ver Demo</a>
                        <input type="button" value="&nbsp;Atrás&nbsp;" class="btn btn-danger hidden" onClick="inicio()">
                        <input type="button" value="&nbsp;Agregar&nbsp;" class="btn btn-success hidden" id="btnAceptar">
                    </div>

                </div>
				<div class="row">
					<div class="span12 text-left">
                <!-- <input type="button" value="&nbsp;Atr&aacute;s&nbsp;" class="btn btn-danger" onClick="inicio()"> -->
					</div>
				</div>


	           <br>
		    <div class="row">
                <div class="span5"></div>
		    	<div class="span6">
		    		<ol class="sortable rounded-list">
		    		<?php while ($fila = mysql_fetch_array($resultado, MYSQL_NUM)) {?>
		    			<li  id="list_<?php echo $fila['0'];?>" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"> <div > <?php echo ($fila['2']);?></div></li>
		    		<?php } ?>
		    		</ol>

		    	</div>

		    </div>
		    <div class="row hidden">
		    	<div class="span10" style="text-align: right">
		    		<input type="button" name="nuevo" id="save_bt" value="Aceptar"  class="btn btn-success" >
		    		<input type="button" name="nuevo" value="Cancelar"  class="btn btn-danger" onClick="inicio()">
		    	</div>
		    </div>
		  </div>

  </div>

  <input type="hidden" name="new_orden" id="new_orden_input" >
</form>

<?php
require("footer.php");
?>
<script type="text/javascript" src="Js/jquery.mjs.nestedSortable.js"></script>

<script type="text/javascript">
$(document).ready(function(){



  $('ol.sortable').nestedSortable({
    disableNesting: 'no-nest',
    forcePlaceholderSize: true,
    handle: 'div',
    helper: 'clone',
    items: 'li',
    maxLevels: 3,
    opacity: .6,
    placeholder: 'placeholder',
    revert: 250,
    tabSize: 25,
    tolerance: 'pointer',
    toleranceElement: '> div',
    update: function () {
        list = $(this).nestedSortable('toArray', {startDepthCount: 0});
        //console.debug("==> list: %o",list);
        $.post(
            'ajax_order_menu.php',
            { action: '2', list: list },
            function(data){
              //$("#result").hide().html(data).fadeIn('slow')
            },
            "html"
        );
    }
	});

  var edit_item = function(the_event){
      console.debug("==> edit_item this : %o",$(this).data());
      item_id= $(this).data('id');
      console.debug(" ==> item_id this: %o",item_id);
      window.location = "edit_menu.php?id="+item_id;
  };


  var remove_item = function(the_event){
      console.debug(" ==> remove_item this: %o",$(this).data());
      item_id= $(this).data('id');
      console.debug(" ==> item_id this: %o",item_id);
      window.location = "sortable_menu.php?id="+item_id;

  };


	$.post(
    'ajax_order_menu.php',
    { action: '1'},
    function(data){

      $("ol.sortable").empty().append(data);
      var menu_items=$("ol.sortable").find("li");
      var links_edit=$(menu_items).find("a.span_edit");
      var links_remove=$(menu_items).find("a.span_remove");
      links_edit.click(edit_item);
      links_remove.click(remove_item);

    },
    "html"
	);


  var menu_items=$("#menu").find("li");

  console.debug("===> menu_items: %o", menu_items.length);

  menu_items.find("a.span_edit").click(function(){
    console.debug("===> CLICKED");
    var _this=$(this);
  });

//$("span.span_edit").on("click",function(){
/*
$(document).live("click","a.span_edit",function(){
    console.debug("Clicked span_edit");
    return false;
});

$(document).live("click","a.span_remove",function(){
    ////$("span.span_remove").on("click",function(){
    console.debug("Clicked span_delete: %o");
    return false;

});
// $(document).live("click",".span_edit",function(){*/


});

</script>
