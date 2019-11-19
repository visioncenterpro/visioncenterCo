</section>
</div>
<script type="text/javascript">
	$(function(){
		var array_quantity = document.querySelectorAll("#quantity_packets");
		var arr_q = [];
		array_quantity.forEach(function(element){
			arr_q.push(element.value);
		});

		var array = document.querySelectorAll("#qrcode1");
		var cont = 1;
		array.forEach(function(element){
			var code = element.value;
	        var qrcode = new QRCode(document.getElementById("qrcode-"+cont), {
				text: code,
				width: 100,
				height: 100,
				colorDark : "#000000",
				colorLight : "#ffffff",
				correctLevel : QRCode.CorrectLevel.H
			});
			cont++;
		});
	});
</script>
</body>
</html>
