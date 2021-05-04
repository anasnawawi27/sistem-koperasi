const flashdata = $('.flash-data').data('flashdata');

if(flashdata){

	Swal.fire(
	  'Berhasil !',
	  'Data Berhasil ' + flashdata,
	  'success'
	);
}
