// JavaScript Document
function checket(ob,vtext)
{ 	 	
  if(ob.checked==true)
  {
  vtext.disabled = false;
  vtext.value = "";
  vtext.focus(); 
  }
 else
 { 
   vtext.value ="";
   vtext.disabled = true;
  }
}
function checketselec(ob,vselec)
{ 	 	
    
  if(ob.checked==true)
  {
   vselec.disabled = false;
   vselec.focus(); 
  }
else
{ 
   vselec.disabled = true;
   
}
}
function no_vacio( nomform)
{
	formulario= document.getElementById(nomform);
	
	for(var i=0; i< formulario.elements.length;i++)
	{
		var elemento = formulario.elements[i];
		if(elemento.type=="text")
		{
			if(elemento.value=="")
			{ 
			  alert("Debe Completar Todos Los Campos.-");
			  elemento.focus();
			  return false;
			}
			 
		}
	}
	formulario.submit();
}

	
function PopWindows(ventana,titulo, alto , ancho)
{ 
window.open(ventana,titulo, "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=yes,fullscreen=no,height="+alto+",width="+ancho+"");
}


function ShowDiv(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='none')
	{ 
     document.getElementById(id).style.display='';
    }
	else
	{
     document.getElementById(id).style.display='none';
    }
}

function ShowDiv2(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='none')
	{ 
     document.getElementById(id).style.display='';
    }
	
}
//-->