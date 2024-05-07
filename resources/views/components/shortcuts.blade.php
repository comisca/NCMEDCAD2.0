

<script>
	var listener = new window.keypress.Listener();

	listener.simple_combo("shift s", function() {
		console.log('f6')
        Livewire.dispatch('openmodal')
        // document.getElementById('searchInput').focus()
	})

	listener.simple_combo("f8", function() {
		document.getElementById('cash').value =''
		document.getElementById('cash').focus()
		document.getElementById('hiddenTotal').value =''
	})

	listener.simple_combo("f7", function() {
		console.log('print last : f10')
        Livewire.dispatch('print-last')
	})

	listener.simple_combo("f4", function() {
		var total = parseFloat(document.getElementById('hiddenTotal').value)
		if(total > 0) {
			Confirm(0, 'clearCart', '¿SEGUR@ DE ELIMINAR EL CARRITO?')
		} else
		{
			noty('AGREGA PRODUCTOS A LA VENTA')
		}
	})






</script>
