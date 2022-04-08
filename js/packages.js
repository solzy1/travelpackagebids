class Packages {
	constructor(){

	}

	// profile (EDIT)
	edit_package(){
		$('.edit-package').click(function(){
			let package_id = $.trim($(this).children('.package_id').val());

			$('#package-id').val(package_id);
		});
	}

	set_editpackage(){
		
	}

	// profile (CREATE)
	reset_createpackage(){
		$('#create-a-package').click(function(){
			$('#package-id').val('');
		});
	}
}