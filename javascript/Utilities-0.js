////////////////////////////////////////////////////////////////////////////////////////////
//			VARIABLES

//Colores Administrador
//Menu
COLOR_MENU_TABLA_CATEGORIA_ADMIN_MOUSEOUT = '#006699';
COLOR_MENU_TABLA_CATEGORIA_ADMIN_MOUSEOVER = '#FF6600';
COLOR_MENU_TABLA_SALIDA_ADMIN_MOUSEOUT = '#333366';
COLOR_FONT_TABLA_CATEGORIA_ADMIN_MOUSEOUT = '#FFFFFF';
COLOR_FONT_TABLA_CATEGORIA_ADMIN_MOUSEOVER = '#FFFFFF';

COLOR_MENU_TABLA_SUBCATEGORIA_ADMIN_MOUSEOUT = '#CCCCCC';
COLOR_MENU_TABLA_SUBCATEGORIA_ADMIN_MOUSEOVER = '#FF6600';
COLOR_FONT_TABLA_SUBCATEGORIA_ADMIN_MOUSEOUT = '#000000';
COLOR_FONT_TABLA_SUBCATEGORIA_ADMIN_MOUSEOVER = '#FFFFFF';

//Paginación
COLOR_FILA_PAGINACION_ADMIN_MOUSEOUT = '#E8E8E8';
COLOR_FILA_PAGINACION_ADMIN_MOUSEOVER = '#999999';
COLOR_FONT_FILA_PAGINACION_ADMIN_MOUSEOUT = '#000000';
COLOR_FONT_FILA_PAGINACION_ADMIN_MOUSEOVER = '#FFFFFF';

//Botones
COLOR_BOTON_AYUDA_ADMIN_MOUSEOUT= '#FF6600';
COLOR_BOTON_AYUDA_ADMIN_MOUSEOVER= '#999999';
COLOR_BOTON_SUBMIT_ADMIN_MOUSEOUT= '#333366';
COLOR_BOTON_SUBMIT_ADMIN_MOUSEOVER= '#999999';

//Opacidad Imagenes
OPACITY_MOUSEOVER=100;
OPACITY_MOUSEOUT=50;


//Colores Extranet
//Botones
COLOR_BOTON_MOUSEOVER= '#EEEECC';
COLOR_BOTON_MOUSEOUT= '#356799';
COLOR_BOTON_SUBMIT_MOUSEOVER= '#F0E68C';
COLOR_BOTON_SUBMIT_MOUSEOUT= '#356799';
COLOR_FONT_PESTANNA_FORMULARIO_MOUSEOVER= '#000000';
COLOR_FONT_PESTANNA_FORMULARIO_MOUSEOUT= '#356799';

//Paginación
COLOR_FILA_PAGINACION_MOUSEOUT = '#FFFFEE';
COLOR_FILA_PAGINACION_MOUSEOVER = '#ECF6FF';
COLOR_FONT_FILA_PAGINACION_MOUSEOUT = '#000000';
COLOR_FONT_FILA_PAGINACION_MOUSEOVER = '#000000';

////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES

//Desplegar Capas
function desplegar_capa(Lay)
{
 	Cab=eval(Lay.id)
 	with (Cab.style) 
 		if (display=="none")
    		display="" 
   		else 
    		display="none" 
}

//intercambiar una capa por otra, modificando el atributo del estilo
function cambiar_capa(num1, num2) 
{ 
	document.getElementById("link"+num1).style.visibility='hidden'; 
	document.getElementById("link"+num2).style.visibility='visible'; 
}

//ocultar un numero de capas
function ocultarCapas(numCapas)
{
	for(i=1; i<=numCapas; i++)
	{
		document.getElementById("capa"+i).style.display='none'; 
	}
} 

//confirmacion para salir
function exit()
{
    if(!confirm ("¿Desea terminar la sesión de trabajo?"))
      return false;
    parent.location.href = 'close_sesion.php';
    return true;
}

function exit2(Mensaje)
{
    if(!confirm (Mensaje))
      return false;
    parent.location.href = 'close_sesion.php';
    return true;
}

//Función a llamar en caso que un item del menu no tenga link
function vacio()
{
}

//generar un select dependiendo de una opcion escogida anteriormente
function preparar_select(control, controlToPopulate, ItemArray, GroupArray, ValueArray, Id)
{
	var myEle ;
	var x ;
	var IndexVal = 0;
	
	// limpiar el segundo select
	for (var q=controlToPopulate.options.length;q>=0;q--)
		controlToPopulate.options[q]=null;
		
	// adicionar los elementos al segundo select
	for ( x = 0, j=0; x < ItemArray.length; x++ )
	{
		if ( GroupArray[x] == control.value )
		{
			myEle = document.createElement("option");
			myEle.value = ValueArray[x];
			myEle.text = ItemArray[x];
			//seleccionar la opcion inicial
			if(ValueArray[x] == Id)
			{
				IndexVal = j;
			}
			//
			controlToPopulate.add(myEle);
			j++;
		}
	}
	controlToPopulate.selectedIndex = IndexVal;
}

//cambio de color en objetos
function mOvr(src, clrOver, clrFont, wFont) 
{
	src.style.cursor= 'pointer';
	src.style.backgroundColor= clrOver;
 	src.style.color= clrFont;
 	src.style.fontWeight= wFont;
}

function mOut(src, clrOut, clrFont, wFont)
{
 	src.style.cursor= 'default';
 	src.style.backgroundColor= clrOut;
 	src.style.color= clrFont;
 	src.style.fontWeight= wFont;	
}

//cambio de color en imagenes para vinculos
function lightup(imageobject, opacity)
{
	if (navigator.appName.indexOf("Netscape")!=-1 && parseInt(navigator.appVersion)>=5)
    		imageobject.style.MozOpacity=opacity/100
 	else if (navigator.appName.indexOf("Microsoft")!= -1 &&parseInt(navigator.appVersion)>=4)
    	imageobject.filters.alpha.opacity=opacity
 	//
 	imageobject.style.cursor= 'pointer';
}

//mediante un onchange redireccionamos a una página
function IrA(option) 
{
	var URL = option.options[option.selectedIndex].value;
 	if(URL=='')
  		return false;
 	window.location.href = URL;
 	option.selectedIndex=0;
}

//abrir ventana
function AbreVentanaGeneral(ventana, nombre, toolbar, menubar, directories, status, resizable, location, scrollbars, width, height, screenX, screenY) {
	var properties = "";
	properties = "toolbar=" + toolbar + ",menubar=" + menubar + ",directories=" + directories + ",status=" + status + ",resizable=" + resizable + ",location=" + location + ",scrollbars=" + scrollbars + ",width=" + width + ",height=" + height + ",screenX=" + screenX + ",screenY=" + screenY;
	//
	return(window.open(ventana, nombre, properties));
}

//Funcion para imprimir consultas
function retorna_imprime() 
{
	window.print();
}

//redimensionar ventana
function resize()
{
	window.focus();
	window.resizeTo(600,600);
	window.moveTo(290,200);	
}

function abrir_ventana_mensaje(event, id) 
{
	var el, x, y;
	el = document.getElementById(id);
	if (window.event) 
	{
		x = window.event.clientX + document.documentElement.scrollLeft
        	                     + document.body.scrollLeft;
	    y = window.event.clientY + document.documentElement.scrollTop +
    	                         + document.body.scrollTop;
  	}
  	else 
  	{
    	x = event.clientX + window.scrollX;
	    y = event.clientY + window.scrollY;
  	}	
	  x -= 2; y -= 2;
	  el.style.left = x + "px";
	  el.style.top  = y + "px";
	  el.style.visibility = "visible";
}

function cerrar_ventana_mensaje(event) 
{  
	var current, related;
	if (window.event)
	{    
		current = this;    
		related = window.event.toElement;  
	}  
	else
	{    
		current = event.currentTarget;    
		related = event.relatedTarget;  
	}  
	if (current != related && !contains(current, related))    
		current.style.visibility = "hidden";
}

//cambiar url
function cambia_url(url) 
{
	cadena = new String;
	cadena = url;
	//
	for(i=0; i<cadena.length; i++){
		cadena = cadena.replace('&', '|');
	}
	//
	for(i=0; i<cadena.length; i++){
		cadena = cadena.replace('?', '¿');
	}
	return cadena;
}

// funciones para manejo de estados en botones y banner
function MM_findObj(n, d)
{ //v4.01
	var p,i,x;  
	//
	if(!d) d=document;
	//
	if((p=n.indexOf("?"))>0&&parent.frames.length) 
	{
		d=parent.frames[n.substring(p+1)].document; 
		n=n.substring(0,p);
	}
  	if(!(x=d[n])&&d.all) x=d.all[n]; 
	for (i=0;!x&&i<d.forms.length;i++) 
		x=d.forms[i][n];
  	for(i=0;!x&&d.layers&&i<d.layers.length;i++) 
		x=MM_findObj(n,d.layers[i].document);
  	if(!x && d.getElementById) 
		x=d.getElementById(n); 
	return x;
}
//
function MM_swapImage() 
{	//v3.0
  	var i,j=0,x,a=MM_swapImage.arguments; 
	document.MM_sr=new Array; 
	for(i=0;i<(a.length-2);i+=3)
   		if ((x=MM_findObj(a[i]))!=null)
		{
			document.MM_sr[j++]=x; 
			if(!x.oSrc) 
				x.oSrc=x.src; 
			x.src=a[i+2];
		}
}
//
function MM_swapImgRestore() 
{	//v3.0
  	var i,x,a=document.MM_sr; 
	for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) 
		x.src=x.oSrc;
}
//
function MM_preloadImages() 
{	//v3.0
 	var d=document; 
	if(d.images)
	{
		if(!d.MM_p)
			d.MM_p=new Array();
   		var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
		for(i=0; i<a.length; i++)
   			if (a[i].indexOf("#")!=0)
			{
				d.MM_p[j]=new Image; 
				d.MM_p[j++].src=a[i];
			}
	}
}


/*
//Inhabilita click derecho
function botonderecho() {
return false
}
document.oncontextmenu=botonderecho
//
*/

//Fechas
//Ver si una fecha introducida es valida
function EsFecha(campo)
{
	var dateStr=campo.value;
	if(dateStr)
	{ 
		var datePat = /^(\d{4})(\/|-)(\d{1,2})\2(\d{1,2})$/;
		var matchArray = dateStr.match(datePat);
		if (matchArray == null) 
			return false;
		day = matchArray[4];
		month = matchArray[3];
		year = matchArray[1];
		if (month < 1 || month > 12) 
			return false;
		if (day < 1 || day > 31) 
			return false;
		if ((month==4 || month==6 || month==9 || month==11) && day==31) 
			return false;
		if (month == 2)
		{
			var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
			if (day>29 || (day==29 && !isleap)) 
				return false;
		}
		return true;
	}
	return true;
}

//
//validar si una fecha es mayor a otra
function Fecha_Mayor(fec0, fec1)
{ 
	var Res = false;
	var Ano0 = fec0.value.substr(0, 4);
	var Mes0 = fec0.value.substr(5, 2); 
	var Dia0 = fec0.value.substr(8, 2); 
	var Ano1 = fec1.value.substr(0, 4);
	var Mes1 = fec1.value.substr(5, 2); 
	var Dia1 = fec1.value.substr(8, 2); 
	//
	if (Ano0 > Ano1)
	{
		Res = true;
	}
	else
	{ 
     	if (Ano0 == Ano1)
		{ 
      		if (Mes0 > Mes1)
			{
				Res = true;
			}
      		else 
			{
				if (Mes0 == Mes1)
				{
					if (Dia0 > Dia1) 
					{
						Res = true;
					}
      			} 
     		} 
    	}
	}
    return Res; 
} 
//
//validar si una fecha es menor 
function Fecha_Menor(fec0, fec1)
{ 
	var Res = false;
	var Ano0 = fec0.value.substr(0, 4);
	var Mes0 = fec0.value.substr(5, 2); 
	var Dia0 = fec0.value.substr(8, 2); 
	var Ano1 = fec1.value.substr(0, 4);
	var Mes1 = fec1.value.substr(5, 2); 
	var Dia1 = fec1.value.substr(8, 2); 
	//
	if (Ano0 < Ano1)
	{
		Res = true;
	}
	else
	{ 
     	if (Ano0 == Ano1)
		{ 
      		if (Mes0 < Mes1)
			{
				Res = true;
			}
      		else 
			{
				if (Mes0 == Mes1)
				{
					if (Dia0 < Dia1) 
					{
						Res = true;
					}
      			} 
     		} 
    	}
	}
    return Res; 
} 
//
//validar si una fecha es menor o igual
function Fecha_Menor_Igual(fec0, fec1)
{ 
	var Res = false;
	var Ano0 = fec0.value.substr(0, 4);
	var Mes0 = fec0.value.substr(5, 2); 
	var Dia0 = fec0.value.substr(8, 2); 
	var Ano1 = fec1.value.substr(0, 4);
	var Mes1 = fec1.value.substr(5, 2); 
	var Dia1 = fec1.value.substr(8, 2); 
	//
	if (Ano0 < Ano1)
	{
		Res = true;
	}
	else
	{ 
     	if (Ano0 == Ano1)
		{ 
      		if (Mes0 < Mes1)
			{
				Res = true;
			}
      		else 
			{
				if (Mes0 == Mes1)
				{
					if (Dia0 <= Dia1) 
					{
						Res = true;
					}
      			} 
     		} 
    	}
	}
    return Res; 
} 
//
//validar si una fecha es mayor o igual
function Fecha_Mayor_Igual(fec0, fec1)
{ 
	var Res = false;
	var Ano0 = fec0.value.substr(0, 4);
	var Mes0 = fec0.value.substr(5, 2); 
	var Dia0 = fec0.value.substr(8, 2); 
	var Ano1 = fec1.value.substr(0, 4);
	var Mes1 = fec1.value.substr(5, 2); 
	var Dia1 = fec1.value.substr(8, 2); 
	//
	if (Ano0 > Ano1)
	{
		Res = true;
	}
	else
	{ 
     	if (Ano0 == Ano1)
		{ 
      		if (Mes0 > Mes1)
			{
				Res = true;
			}
      		else 
			{
				if (Mes0 == Mes1)
				{
					if (Dia0 >= Dia1) 
					{
						Res = true;
					}
      			} 
     		} 
    	}
	}
    return Res; 
} 
//
//redondear valores
function redondear_valor(valor, precision, simbolo)
{
    valor = "" + valor //convertir el valor en cadena
    precision = parseInt(precision);
	//
	var whole = "" + Math.round(valor * Math.pow(10, precision));
	var decPoint = whole.length - precision;
	//
	if(decPoint != 0)
	{
		result = whole.substring(0, decPoint);
        result += simbolo;
        result += whole.substring(decPoint, whole.length);
	}
	else
	{
		result = 0;
		result += simbolo;
		result += whole.substring(decPoint, whole.length);
	}
    return result;
}

//Validar Email
function validar_email(valor) 
{
	var Res = false;
	var email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	
	if(email.test(valor)) 
	{ 
		Res = true;	
    }

   	return Res; 
 }

//conteo de caracteres de un textarea
function Contador_TextArea(campo, campo_contador, limite_maximo) 
{
	if (campo.value.length > limite_maximo)
		campo.value = campo.value.substring(0, limite_maximo);
	else
		campo_contador.value = limite_maximo - campo.value.length;
}


//validar extensiones de un adjunto
function extensiones_adjunto(file, extArray)
{
	allowSubmit = false;
	if (!file)
		return false;
	//
	while (file.indexOf("\\") != -1)
		file = file.slice(file.indexOf("\\") + 1);
		
	ext = file.slice(file.indexOf(".")).toLowerCase();
	//
	for (var i = 0; i < extArray.length; i++) 
	{
		if (extArray[i] == ext)
		{
			allowSubmit = true;
			break;
		}
	}	
	//
	if (allowSubmit) 
		return true;
	//
	else if(!allowSubmit) 
		return false;
}

//validar hora formato hh:mm:ss AM/PM
function ValidaHora(hora){
	var er_fh = /^(1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12)\:([0-5]0|[0-5][1-9])\ (AM|PM)$/
	
	if(hora.value == "" ){
		return false
	}
	//
	if ( !(er_fh.test(hora.value )) ) { 
		return false
	}
	//
	return true
}

///////////////////////////////////////////////////////