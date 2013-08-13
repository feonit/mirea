/*!
 * Tests for blocks
 * Working email: feonitu@yandex.ru
 * Date: Mon Oct 24 21:11:03 2012
 */
	function get_color_1() {
		var tbody = document.getElementsByTagName('tbody')[0];		
		for (var n = 0; n < 20; n++){
		var tr = tbody.getElementsByTagName('tr')[n];
			if (n % 2){
				for (var y = 0; y < 2; y++){
				if (tr.getElementsByTagName('td')[y] !=null){
					var td = tr.getElementsByTagName('td')[y];
					td.style.color='#666666';
					}
				}
			}
		}
	}

	function get_color_2() {
		jQuery("tbody:eq(1)").find("tr").filter(function(index){
			return(index % 2)
		}).find("td").css("color", "#555555");
	}
	
	function get_color_3() {
		var lis = $$('#block3 tr');
		for (var q = 0; q < 10; q++){
			lis[q*2+1].addClass('selected'); 
		}
	}
	