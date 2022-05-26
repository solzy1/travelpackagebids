$(function () {
	const _file_upload = new File_Upload();

	_file_upload.receive();
});


class File_Upload {
	constructor(){

	}

	append(src, filename, filetype = ''){
		$('#itenary-file').val(src);

		filename = filename==="" ? '' : filename + ' was selected!';
        $('#file-name').html("<span style='font-size: 13px'>" + filename + "</span>").removeClass('d-none');
	}
	
	upload(selected){ // if file exists, upload the received file
		let selected_file = selected.files[0];

        // SELECT AND UPLOAD THE SELECTED FILE TO THE IMAGE TAG
     	let _file = new  File_Upload();

        if(selected_file!=undefined){
            let reader = new FileReader();

            selected_file.title = selected_file.name;

            reader.onload = function(event) {
                let src = event.target.result;

                _file.append(src, selected_file.title, selected_file.type); // add the uploade image to the selected image tag

                _file.loader(false, selected); // hide image loader, after upload is complete
			};

            reader.readAsDataURL(selected_file);
        }
        else {
            _file.loader(false, selected); // hide image loader, after upload is complete}
            _file.append('', ''); // reset the value for itenary file and file name display
		}
	}

	receive(){ // receive the response on file/image upload
		const _file = new  File_Upload();

		$('.uploadfromlib').on('change', function(){
            _file.loader(true, this); // show image loader, after upload is complete (in _admin.js)

            _file.upload(this); // upload the selected image
		});
	}

	loader(show, file){
		if(show){
			$('#loader').removeClass('d-none');
			$('.addpic').css({'cursor': 'not-allowed', 'opacity': 0.3});
			$(file).attr('disabled', true);
		}
		else{
			$('#loader').addClass('d-none');	
			$('.addpic').css({'cursor': '', 'opacity': 1});
			$(file).removeAttr('disabled');
		}
	}
}