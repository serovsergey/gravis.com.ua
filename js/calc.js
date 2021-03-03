    let tooltipElem;

    document.onmouseover = function(event) {
      let target = event.target;

      let tooltipHtml = target.dataset.tooltip;
      if (!tooltipHtml) return;

      tooltipElem = document.createElement('div');
      tooltipElem.className = 'tooltip';
      tooltipElem.innerHTML = tooltipHtml;
      document.body.append(tooltipElem);

      let coords = target.getBoundingClientRect();

      let left = coords.left + (target.offsetWidth - tooltipElem.offsetWidth) / 2;
      if (left < 0) left = 0;

      let top = coords.top - tooltipElem.offsetHeight - 5;
      if (top < 0) {
        top = coords.top + target.offsetHeight + 5;
      }

      tooltipElem.style.left = left + 'px';
      tooltipElem.style.top = top + 'px';
    };

    document.onmouseout = function(e) {

      if (tooltipElem) {
        tooltipElem.remove();
        tooltipElem = null;
      }

    };
	Array.prototype.move = function(element, offset) {
	  const index = this.indexOf(element);
	  const newIndex = index + offset;
	  
	  if ((newIndex > -1) && (newIndex < this.length)) {
		// Remove the element from the array
		const removedElement = this.splice(index, 1)[0];
	  
		// At "newIndex", remove 0 elements, insert the removed element
		return this.splice(newIndex, 0, removedElement);
	  }
	};
	
	function readFields(elem, fields){
		
	}
	
	function openElemGroup(elem){
		let e = elem;
		while(e.parentElement.id != "calc_form"){
			e = e.parentElement;
			e.classList.remove("closed");
		}
	}
	
	function closeAllGroups(){
		let groups = document.querySelectorAll("div.input_group, div.group_content");
		for(let i = 0; i < groups.length; i++) {
			groups[i].classList.add("closed");
		}
	}
	
	function loadFields(id, altFields = ""){
		let fields;
		
		if(altFields != "") fields = altFields;
		else fields = JSON.parse(sessionStorage.getItem(id));
		//console.log(fields);
		for(name in fields){
			//console.log(name + " = " + fields[name]);
			let elem = document.getElementById("_"+name);
			if(elem) {
				elem.value = fields[name];
				openElemGroup(elem);
			}
		}
	}
	
	function updateGroupsState(){
		
	}
	
	function moveUp(jsonArray, element){
		return jsonArray;
	}

	function moveDown(jsonArray, element){
		return jsonArray;
	}
						 
	function updateMoveGrips(){
		let spec_tables = document.getElementById("tab_content").getElementsByClassName("calc_details");
		for(var i = 0; i < spec_tables.length; i++){
			spec_tables[i].querySelector("img.moveUp").style.display = (i > 0 ? "" : "none");
			spec_tables[i].querySelector("img.moveDown").style.display = (i < spec_tables.length - 1 ? "" : "none");		
		}
	}
	
	function swapEntries(obj, keyFrom, keyTo){
		//console.log(`keyFrom=${keyFrom}, keyTo=${keyTo}`);
		let newObj = {};
		Object.keys(obj).forEach(function(key){
			let val = obj[key];
			if(key === keyFrom){
				newObj[keyTo] = obj[keyTo];
				//console.log(`new1 - ${keyTo}:${obj[keyTo]}`);
			} else if(key === keyTo) {
				newObj[keyFrom] = obj[keyFrom];
				//console.log(`new2 - ${keyFrom}:${obj[keyFrom]}`);
			} else newObj[key] = val;
			//console.log(`old - ${key}:${val}`);
		});
		return newObj;
	}
	
	function showErrorWindow(errorText, timeOut, target){
		let error_window = document.createElement("div");
		let coords = target.getBoundingClientRect();
		
		error_window.className = "error-window";
		error_window.innerHTML = errorText;
		document.body.append(error_window);
		if(target){
			let left = coords.left + (target.offsetWidth - error_window.offsetWidth) / 2;
			if (left < 0) left = 0;
			let top = coords.top - error_window.offsetHeight - 5;
			if (top < 0) {
				top = coords.top + target.offsetHeight + 5;
			}
			error_window.style.left = left+"px";
			error_window.style.top = top+"px";
			error_window.style.right = "inherit";
			error_window.style.bottom = "inherit";
		}
		$(".error-window").effect("pulsate", {times:3}, 500);
		setTimeout(function(){
			error_window.remove();
		}, timeOut);
	}
	
	function loadTab(id){
		let tab_content = document.getElementById("tab_content");
		tab_content.innerHTML = '<div class="lds-dual-ring"></div>';
		let li = document.getElementById(id);
		li.classList.remove("editing");
		if(id == "spec_tab"){
			var spec_text = localStorage.getItem("spec");	
			var spec = JSON.parse(spec_text);
			var content = "";
			if((spec) && (Object.keys(spec).length > 0)){
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "/api/",
					data: "calc.start="+spec_text,
					timeout: 3000,
					error: function(jqXHR, textStatus){
						tab_content.innerHTML = "Ошибка загрузки данных: " + textStatus;
						console.log("error");
					},
					success: function (json){
						console.log("success");
						tab_content.innerHTML = json.response.result;
						updateMoveGrips();
						$(".editTable").click(function(e) {
							let tbl = this.closest("table");
							editTimeStamp = tbl.dataset.timestamp;
							let editId = tbl.dataset.id;
							document.getElementById(editId).dataset.edit_timestamp = editTimeStamp;
							document.getElementById(editId).click();
							//$("#spec_tab").effect("transfer", {to:$("#"+editId)}, 500); 
						});
						$(".copyToClipboard").click(function(e) {
							e.preventDefault();	
							copyToClipboard(this.closest("table"), this);
						});
						$(".deleteTable").click(function(e) {
							var spec_text = localStorage.getItem("spec");	
							var spec = JSON.parse(spec_text);
							var timestamp = this.closest("table").dataset.timestamp;
							if(timestamp in spec) {
								tabCaption = spec[timestamp]["caption"];
							}
							if(confirm('Удалить таблицу "'+tabCaption+'"?')){
								delete spec[timestamp];
								if(Object.keys(spec).length > 0) localStorage.setItem("spec", JSON.stringify(spec));
								else {
									localStorage.removeItem("spec");
									updateSpecTab();
								}
								loadTab(id);
							}
						});
						$(".moveUp").click(function(e) {
							var spec_text = localStorage.getItem("spec");	
							var spec = JSON.parse(spec_text);
							var timestamp = this.closest("table").dataset.timestamp;
							let index = Object.keys(spec).indexOf(timestamp);
							if((index == 0) || (spec.length < 2)) return; // некуда двигать
							let timestamp2 = Object.keys(spec)[index - 1];
							spec =  swapEntries(spec, timestamp, timestamp2);
							localStorage.setItem("spec", JSON.stringify(spec));
							$(`.calc_details[data-timestamp='${timestamp}']`).effect("transfer", {to:$(`.calc_details[data-timestamp='${timestamp2}']`)}, 500);
							$(`.calc_details[data-timestamp='${timestamp2}']`).effect("transfer", {to:$(`.calc_details[data-timestamp='${timestamp}']`)}, 500);
							$(`.calc_details[data-timestamp='${timestamp}']`).insertBefore($(`.calc_details[data-timestamp='${timestamp2}']`));
							updateMoveGrips();
						});
						$(".moveDown").click(function(e) {
							var spec_text = localStorage.getItem("spec");	
							var spec = JSON.parse(spec_text);
							var timestamp = this.closest("table").dataset.timestamp;
							let index = Object.keys(spec).indexOf(timestamp);
							if((index == spec.length - 1) || (spec.length < 2)) return; // некуда двигать
							let timestamp2 = Object.keys(spec)[index + 1];
							spec =  swapEntries(spec, timestamp, timestamp2);
							localStorage.setItem("spec", JSON.stringify(spec));
							$(`.calc_details[data-timestamp='${timestamp}']`).effect("transfer", {to:$(`.calc_details[data-timestamp='${timestamp2}']`)}, 500);
							$(`.calc_details[data-timestamp='${timestamp2}']`).effect("transfer", {to:$(`.calc_details[data-timestamp='${timestamp}']`)}, 500);
							$(`.calc_details[data-timestamp='${timestamp2}']`).insertBefore($(`.calc_details[data-timestamp='${timestamp}']`));
							updateMoveGrips();
						});
						$(".copySpecToClipboard").click(function(e) {
							let tab_content = document.getElementById("tab_content");
							$('.calc_details').addClass('clipboard');
							$('.table_button_group').hide(); 

							var body = document.body, range, sel;
							if (document.createRange && window.getSelection) {
								range = document.createRange();
								sel = window.getSelection();
								sel.removeAllRanges();
								try {
									range.selectNodeContents(tab_content);
									sel.addRange(range);
								} catch (e) {
									range.selectNode(tab_content);
									sel.addRange(range);
								}
							} else if (body.createTextRange) {
								range = body.createTextRange();
								range.moveToElementText(tab_content);
								range.select();
								//range.execCommand("copy");
							}
							document.execCommand("copy");
							clearSelection();
							$('.table_button_group').show();
							$('.calc_details').removeClass('clipboard');
							$(".calc_details").effect("transfer", {to:this}, 500);
						});
						$(".printSpec").click(function(e) {
							window.print();
						}); 
						$(".saveSpec").click(function(e) {
							function download(content, fileName, contentType) {
								let a = document.createElement("a");
								let file = new Blob([content], {type: contentType});
								a.href = URL.createObjectURL(file);
								a.download = fileName;
								a.click();
								URL.revokeObjectURL(a.href);
							}
							download(JSON.stringify(spec, null, '\t'), 'spec.json', 'application/json');
						});
						
						function onReaderLoad(event){
							let json_text = event.target.result;
							try {
								JSON.parse(json_text);
							} catch (e) {
								alert("Неверный формат файла!");
								return;
							}
							localStorage.setItem("spec", json_text);
							updateSpecTab();
							loadTab(id);
						}
						let reader = new FileReader();
						reader.onload = onReaderLoad;
						$("#specFile").change(function(e) {
							reader.readAsText(event.target.files[0]);
						});
						$(".loadSpec").click(function(e) {
							$("#specFile").click();
						});
						
						$(".deleteSpec").click(function(e) {
							if(confirm('Удалить спецификацию?')){
								localStorage.removeItem("spec");
								updateSpecTab();
							}
						});
						$(".spec_caption").click(function(e) {
							let spec_text = localStorage.getItem("spec");	
							let spec = JSON.parse(spec_text);
							let timestamp = this.closest("table").dataset.timestamp;
							if(timestamp in spec) {
								oldName = spec[timestamp]["caption"];
							}
							let canvas_name = prompt("Введите название полотна", oldName);
							canvas_name = canvas_name.replace(/<[^>]+>/g,'');
							if(canvas_name) {
								spec[timestamp]["caption"] = canvas_name;
								localStorage.setItem('spec', JSON.stringify(spec));
								this.innerHTML = canvas_name;
							}
						});
					}
				});
			} else content = "Ошибка";
			//tab_content.innerHTML = content;
		} else {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/api/",
				data: 'calc.formContent={"id":"'+id+'"}', 
				success: function (json){				
					tab_content.innerHTML = json.response.content;
					let altFields = "";
					//console.log("tab_content.hasAttribute('edit_timestamp') = " + typeof(tab_content.dataset.edit_timestamp));
					let editTimeStamp = li.dataset.edit_timestamp;
					if(editTimeStamp){
						specJson = localStorage.getItem("spec");
						spec = JSON.parse(specJson);
						if(spec.hasOwnProperty(editTimeStamp)){
							$("#spec_tab").effect("transfer", {to:$("#tab_content")}, 500); 
							altFields = spec[editTimeStamp];
							//console.log(altFields["caption"]);
							let calc_form = document.getElementById("calc_form");
							calc_form.dataset.edit_timestamp = editTimeStamp;
							let caption = document.createElement("div");
							caption.id = "edit_caption";
							caption.innerHTML = 'Правка таблицы: "' + altFields["caption"] + '"';
							caption.style.fontWeight = "bold";
							caption.style.color = "red";
							calc_form.insertBefore(caption, calc_form.firstChild);
							//li.classList.add("editing");
							delete li.dataset.edit_timestamp;
						}
					}
					loadFields(id, altFields);
					$(".resetForm").click(function(e) {
						e.preventDefault();	
						document.getElementById("calc_form").reset();
						sessionStorage.removeItem(id);
						li.classList.remove("editing");
						let caption = document.getElementById("edit_caption");
						if(caption)
							caption.outerHTML = "";
						closeAllGroups();
						delete document.getElementById(id).dataset.edit_timestamp; 
					});
					$(".translateToCustom").click(function(e) {
						e.preventDefault();

						var elem = getCurrentTab();
						var form_id = elem.id;
						var preStrFields='"id":"'+form_id+'"';
						var strFields = '';
						strFields += getChildFields(document.getElementById('calc_form'));
						$.ajax({
							type: "POST",
							dataType: "json",
							url: "/api/",
							data: "calc.translateToCustom={"+preStrFields+strFields+"}",
							success: function (json){
								if("errorno" in json.response){
									showErrorWindow("Недостаточно данных!!!", 1500, document.getElementsByClassName("translateToCustom")[0]);
								} else {
									$(`#${id}`).effect("transfer", {to:$(`#input_form`)}, 500);
									let translatedFields = JSON.parse(json.response.result);
									delete translatedFields.id;
									sessionStorage.setItem("custom", JSON.stringify(translatedFields));
									$("li#custom").click();
								}
							}
						});
					});
				}
			});
		}
	}

	function getCurrentTab(){
		var elems = document.getElementById("forms_list").getElementsByClassName('current');
		for(var i=0; i < elems.length; i++){
			var elem = elems[i];
			if(elem.parentElement.id == 'forms_list') return elem;
		}
		//console.log("CurrentTab is null");
		return null;
	}
	
	function getChildFields(parent){
		var strFields = "";
		var elems = parent.children;
		for(var i=0; i < elems.length; i++){
			var elem = elems[i];
			switch(elem.tagName){
				case "INPUT":
						var val = elem.value.toString();
						if(val != ''){
							if(elem.type == 'checkbox') {
								if(!elem.checked) continue; 
								val = '1';
							}
							strFields += ', "'+elem.name.toString()+'":';
							strFields += '"'+val+'"';
						}
					break;
				case "SELECT":
						if(elem.value.toString()!=''){
							strFields += ', "'+elem.name.toString()+'":';
							strFields += '"'+elem.value.toString()+'"';
						}
					break;
				default:
					if(!elem.classList.contains("closed")) strFields += getChildFields(elem);
			}
		}
		return strFields;
	}
	
	function calcStart(){
		var elem = getCurrentTab();
		var form_id = elem.id;
		var preStrFields='"id":"'+form_id+'"';
		var strFields = '';

		strFields += getChildFields(document.getElementById('calc_form'));
		
		//console.log(strFields);
		let stamp = Date.now();
		let editTimeStamp = document.getElementById("calc_form").dataset.edit_timestamp;
		if(editTimeStamp) {
			stamp = editTimeStamp;
			preStrFields += ',"editing":1';
			//console.log("editing = " + stamp);
		}

		$('#result').html('<div class="lds-dual-ring"></div>');
		//console.log('/api/?calc.start={"stamp":"'+stamp+'", '+preStrFields+strFields+'}');
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/api/",
			data: 'calc.start={"stamp":"'+stamp+'",'+preStrFields+strFields+'}',
			success: function (json){
//		$.getJSON('/api/?calc.start={"stamp":"'+stamp+'",'+preStrFields+strFields+'}', {}, function(json){			
				$('#result').html(json.response.result);
				var calc_details = document.getElementsByClassName("calc_details")[0];
				if(calc_details == null) return;
				var caption = calc_details.getElementsByTagName("CAPTION")[0];
				calc_details.dataset.timestamp = stamp;
				
				sessionStorage.setItem(form_id, '{' + strFields.substring(1) + '}');
				
				$(".copyToClipboard").click(function(e) {
					e.preventDefault();	
					copyToClipboard(this.closest("table"), this);
				});
				$(".addToSpec").click(function(e) {
					e.preventDefault();		
					addToSpec(preStrFields+strFields, calc_details.dataset.timestamp);
				});
			}
		});
	};
	
	function clearSelection(){
		if (window.getSelection) {
		  if (window.getSelection().empty) {  // Chrome
			window.getSelection().empty();
		  } else if (window.getSelection().removeAllRanges) {  // Firefox
			window.getSelection().removeAllRanges();
		  }
		} else if (document.selection) {  // IE?
		  document.selection.empty();
		}
	}
  
	function addToSpec(fields, timestamp){
		var spec_text = localStorage.getItem("spec");
		//alert(timestamp);		
		var spec = JSON.parse(spec_text);
		if(spec == null) spec = {};
		//alert("bbb");
		let oldName = "Потолок ";
		if(timestamp in spec) {
			oldName = spec[timestamp]["caption"];
		}
		var canvas_name = prompt("Введите название полотна", oldName);
		if(canvas_name == null) return;
		var canvas_data = JSON.parse("{" + fields + "}");
		//alert(JSON.stringify(canvas_data));
		canvas_data["caption"] = canvas_name;
		//alert(JSON.stringify(canvas_data));
		spec[timestamp] = canvas_data;
		
		localStorage.setItem('spec', JSON.stringify(spec)); 
		
		updateSpecTab();
		//setTimeout(() => $("#spec_tab").effect("pulsate", {times:3}, 500), 500);
		$(".calc_details").effect("transfer", {to:"#spec_tab"}, 500, function(){
			if(document.getElementById("calc_form").dataset.edit_timestamp) {
				$("#spec_tab").click();
			} else {
				$("#spec_tab").effect("pulsate", {times:3}, 500);
			}
		});
		//$("#spec_tab").effect("pulsate", {times:3}, 500);
		//alert(spec);
	}
	
	function changeTab(oldTab, newTab){
		document.getElementById(oldTab.id).classList.remove("editing");
		newTab.classList.add('current');
		oldTab.classList.remove('current');
		newTab.dataset.last_tab = oldTab.id;
		loadTab(newTab.id);
		$('#result').html('');
	}
		
	function updateSpecTab(){
		//return;
		var spec_text = localStorage.getItem("spec");	
		var spec = JSON.parse(spec_text);
		var spec_tab = document.getElementById("spec_tab");
		if((spec == null) || (spec.length == 0)){
			//spec_tab.style.visibility = "hidden";
			spec_tab.style.display = "none";

			var elem = getCurrentTab();
			if(elem == spec_tab){
				if(spec_tab.dataset.last_tab != null)
					document.getElementById(spec_tab.dataset.last_tab).click();
				else 
					document.getElementById("forms_list").getElementsByTagName("LI")[0].click();
				spec_tab.classList.remove("current");
			}
			//TODO: add LoadSpec button
		}
		else {
			//spec_tab.style.visibility = "visible";
			spec_tab.style.display = "block";
		}
	}
		
	function copyToClipboard(el,button){ 
		var caption = el.getElementsByTagName("CAPTION")[0];
		caption.remove();
		el.classList.add("clipboard");
		var body = document.body, range, sel;
        if (document.createRange && window.getSelection) {
            range = document.createRange();
            sel = window.getSelection();
            sel.removeAllRanges();
            try {
                range.selectNodeContents(el);
                sel.addRange(range);
            } catch (e) {
                range.selectNode(el);
                sel.addRange(range);
            }
        } else if (body.createTextRange) {
            range = body.createTextRange();
            range.moveToElementText(el);
            range.select();
            //range.execCommand("copy");
        }
		document.execCommand("copy");
		clearSelection();
		el.classList.remove("clipboard");
		el.insertBefore(caption, el.firstChild);
		$(el).effect("transfer", {to:button}, 500);
	}
	

	$(document).ready(function(){ 			
		updateSpecTab();
				
		(function() {

			if (!Element.prototype.matches) {

			// определяем свойство
			Element.prototype.matches = Element.prototype.matchesSelector ||
			  Element.prototype.webkitMatchesSelector ||
			  Element.prototype.mozMatchesSelector ||
			  Element.prototype.msMatchesSelector;

		  }

		  if (!Element.prototype.closest) {

			// реализуем
			Element.prototype.closest = function(css) {
			  var node = this;

			  while (node) {
				if (node.matches(css)) return node;
				else node = node.parentElement;
			  }
			  return null;
			};
		  }

		})();
		$(document).on('click', '.group_caption', function(e) {
			var group = e.target.parentElement;
			var group_content = group.getElementsByClassName("group_content")[0];
			group.classList.toggle("closed");
			group_content.classList.toggle("closed");
		});
		
		var curTab = getCurrentTab();
		var firstLI = document.getElementById("forms_list").getElementsByTagName("LI")[0];
		if((curTab == null) || ((curTab.id == "spec_tab") && (document.getElementById("spec_tab").style.visibility == "hidden"))) {
			curTab = firstLI;
			curTab.classList.add("current");
		}
		var url = String(window.location.pathname).replace(/\/+$/g, '').slice(1);
		var pageName = url.split("/")[0];
		var subPage = curTab.id;
		url = window.location.protocol + "//" + window.location.host + "/" + pageName + "/" + subPage;
		history.replaceState("", "", url);
		
		loadTab(curTab.id);
		
		window.addEventListener('storage', function onStorageEvent(storageEvent){
			updateSpecTab();
		}, false);
		
		
		window.onpopstate = function(event) {
			var url = String(window.location).replace(/\/+$/g, '');
			var id = url.split("/").pop();
			var elem = getCurrentTab();
			changeTab(elem, document.getElementById(id));
		};
		
		$('#forms_list > li > a').click(function(e){ 
			var evt = e ? e : window.event;
			evt.preventDefault();
			e.stopPropagation();
			e.target.closest('li').click(e);
		});
		
		$('#forms_list > li').click(function(e){ 
			if(e.target.tagName.toLowerCase() != 'li') return;
			var id = e.target.id; 
			var elem = getCurrentTab();
			if(id==elem.id) return;
			var url = String(window.location).replace(elem.id, '').replace(/\/+$/g, '');
			url += '/' + id;
			history.pushState(elem.id, "", url);
			changeTab(elem, e.target);
		});
	});