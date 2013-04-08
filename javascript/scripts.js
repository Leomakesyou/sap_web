//animacion para las letras
<script language="javascript">
	
        var ie4 = false;
        if(document.all) {
                ie4 = true; 
        }       
        function setContent(name, value) {
                var d;  
                if (ie4) { 
                        d = document.all[name];
                } else {
                        d = document.getElementById(name);
                }       
                d.innerHTML = value;    
        }       

	function getContent(name) {
		var d;
                if (ie4) {
                        d = document.all[name];
                } else {
                        d = document.getElementById(name);
                }
                return d.innerHTML;
	}

        function setColor(name, value) {
                var d;  
                if (ie4) { 
                        d = document.all[name];
                } else {
                        d = document.getElementById(name);
                }
                d.style.color = value;  
        }

	function getColor(name) {
                var d;
                if (ie4) {
                        d = document.all[name];
                } else {
                        d = document.getElementById(name);
                }
                return d.style.color;
        }

        function animate(name, col) {
		var value = getContent(name);
		if (value.indexOf('<span') >= 0) { return; }
		var length = 0;
                var str = '';
		var ch;
		var token = '';
		var htmltag = false;	
                for (i = 0; i < value.length; i++) {
			ch = value.substring(i, i+1);
			if (i < value.length - 1) { nextch = value.substring(i+1, i+2); } else { nextch = ' '; }
			token += ch;
			if (ch == '<' && '/aAbBpPhHiIoOuUlLtT'.indexOf(nextch) >= 0) { htmltag = true; }
			if (ch == '>' && htmltag) { htmltag = false; }
			if (!htmltag && ch.charCodeAt(0) > 30 && ch != ' ' && ch != '\n') {		
                        	str += '<span id="' + name + '_' + length + '">' + token + '</span>';
				token = '';
				length++;
			}
                }
                setContent(name, str);
                command = 'animateloop(\'' + name + '\', ' + length + ', 0, 1, \'' + col + '\')';
                setTimeout(command , 100);
        }

        function animateloop(name, length, ind, delta, col) {
		var next = ind + delta;
		if (next >= length) { delta = delta * -1; next = ind + delta; }
		if (next < 0) { delta = delta * -1; next = ind + delta; }
                setColor(name + '_' + ind, getColor(name + '_' + next));
                setColor(name + '_' + next, col);
                command = 'animateloop(\'' + name + '\', ' + length + ', ' + next + ', ' + delta + ', \'' + col + '\')';
                setTimeout(command , 100);
        }
</script>
//////////////////////////////////////////////fin Animacion


/////////////////////////////////////////////Desplegar Fila
function desplegar_capa(Lay)
{
 	Cab=eval(Lay.id)
 	with (Cab.style) 
 		if (display=="none")
    		display="" 
   		else 
    		display="none" 
}
////////////////////////////////////////////Fin Desplegar Fila


////////////////////////////////////////////Borrar Historial
function Borrar_his()
{
//	alert("Borrar 0");
	window.history.forward(1);
//	alert("Borrado" + window.history.forward(1));
	if(window.history.forward(1) != null)
//	alert("Borrar");
	window.history.forward(1);
}

////////////////////////////////////////////