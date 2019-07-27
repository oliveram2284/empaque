<?php
    include ("config.php");

    
    $sql="select * from tbl_grupos";
    $grupos=  R::getAll($sql);

    $sql="select * from categoria_usuarios";
    $categorias=  R::getAll($sql);

    if(isset($_GET['id'])){
        //var_dump($_GET['id']);
        $sql="select * from usuarios where id_usuario=".$_GET['id']."";
        $usuario=  R::getRow($sql);
        //var_dump($usuario);
    }
?>

<form class="form-horizontal" id="usuario_form">
    <input type="hidden" name="id" id="user_id"  value="<?php echo (isset($usuario))?$usuario['id_usuario']:'-1'; ?>" >
    <div class="control-group">
        <label class="control-label" for="inputEmail">Nombre de Usuario</label>
        <div class="controls">
            <input type="text" id="nombre" name="nombre" class="span4" placeholder="Nombre" value="<?php echo (isset($usuario))?$usuario['nombre']:''; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputPassword">Nombre y Apellido</label>
        <div class="controls">
            <input type="text" id="nombre_real"  name="nombre_real" class="span4" placeholder="Nombre y Apellido" value="<?php echo (isset($usuario))?$usuario['nombre_real']:''; ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPassword">Contraseña</label>
        <div class="controls">
            <input type="password" id="contrasenia" class="span4" name="contrasenia" placeholder=""  value="<?php echo (isset($usuario))?$usuario['contrasenia']:''; ?>" >
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPassword">Grupo</label>
        <div class="controls">
            <select name="id_grupo" id="id_grupo" class="span4"> 
                <option value=""></option>
                <?php foreach ($grupos as $key => $value):?>
                    <option value="<?php echo $value['id_grupo']?>" <?php echo (isset($usuario) && $usuario['id_grupo']==$value['id_grupo'])?'selected':''; ?> ><?php echo $value['descripcion']?></option>
                <?php endforeach;?>
            </select>
            
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPassword">Categoría</label>
        <div class="controls">
            <select name="catId" id="catId" class="span4"> 
                <option value=""></option>
                <?php foreach ($categorias as $key => $value):?>
                    <option value="<?php echo $value['id']?>" <?php echo (isset($usuario) && $usuario['catId']==$value['id'])?'selected':''; ?> ><?php echo $value['descripcion']?></option>
                <?php endforeach;?>
            </select>
            
        </div>
    </div>

    
  
</form>