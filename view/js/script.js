$(document).ready(function(){


	//Familias profesionales		
		$.ajax({
	       	type:"GET",
	       	url: "controller/cFamilias.php", 
	    	dataType: "json",  //type of the result it is not necessary JSON.parse
	       	
	    	success: function(result){  
	       		
	    		console.log(result);    	
	       	
	    		var newRow="";
	    		
	    		newRow += '<h2 class="title">FAMILIAS PROFESIONALES</h2>'
	    		newRow += '<select id="familias">'
	    		
	    		$.each(result,function(index,familia){
	    			newRow += '<option value="'+familia.cod_familia+'">'+familia.nom_familia_es+'</option>'    			
	    		});
	    		
	    		newRow += '</select>'
	    		
	    		$("#familiasProfesionales").html(newRow);
	    		
	    		
	    		//Ciclos formativos	
	    		$( "#familias" ).change(function() {

	    			  var codFam="";
	    			  var nomFam="";
	    			  
	    			  codFam=$(this).attr('selected', 'selected').val();
	    			  nomFam=$("#familias option:selected").text();
	    			  
	    			  $.ajax({
	    			       	type:"GET",
	    			       	data:{'codFam':codFam},
	    			       	url: "controller/cCiclos.php", 
	    			    	dataType: "json",  //type of the result it is not necessary JSON.parse
	    			       	
	    			    	success: function(resultCiclo){  
	    			       		
	    			    		console.log(resultCiclo);    	
	    			       	
	    			    		var ciclos="";
	    			    		ciclos += '<h3 class="title">'+nomFam+'</h3>'
	    			    		ciclos += '<h2 class="title">CICLOS FORMATIVOS</h2>'
	    			    			
	    			    			ciclos += '<select id="ciclos">'
	    			    			$.each(resultCiclo,function(index,ciclo){
	    			    				ciclos += '<option value="'+ciclo.cod_ciclo+'">'+ciclo.nom_ciclo_es+'</option>'    			
	    				    		});
	    			    		ciclos += '</select>'
	    			    		
	    			    		$("#ciclosFormativos").html(ciclos);
	    			    		
	    			    		//Centros
	    			    		$( "#ciclos" ).change(function() {
	    			    			 
	    			    			 codCiclo=$(this).attr('selected', 'selected').val();
	    			    			 $.ajax({
	    			    			       	type:"GET",
	    			    			       	data:{'codCiclo':codCiclo},
	    			    			       	url: "controller/cOferta.php", 
	    			    			    	dataType: "json",  //type of the result it is not necessary JSON.parse
	    			    			       	
	    			    			    	success: function(resultOferta){  
	    			    			       		
	    			    			    		console.log(resultOferta);    	
	    			    			       	
	    			    			    		
	    			    			    		
	    			    			    		
	    			    					},
	    			    			       	error : function(xhr) {
	    			    			   			alert("An error occured: " + xhr.status + " " + xhr.statusText);
	    			    			   		}
	    			    				});
	    			    			 
	    			    		});
	    			    		
	    			    		
	    					},
	    			       	error : function(xhr) {
	    			   			alert("An error occured: " + xhr.status + " " + xhr.statusText);
	    			   		}
	    				});	
	    			  
	    		});
			},
	       	error : function(xhr) {
	   			alert("An error occured: " + xhr.status + " " + xhr.statusText);
	   		}
		});	
}); //document.ready


