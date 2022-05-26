class File_Download {
	constructor(){

	}

	download(_this){
		let parent = $(_this).parent();

		$(_this).css({'cursor': 'not-allowed', 'opacity': 0.7}).prop('disabled', true);

		let itenary_file = parent.children('.itenary-file').val();

		const _file_download = new File_Download();

		let itenary_file_type = _file_download.get_file_type(itenary_file);

		let file_extension = "." + _file_download.get_extension(itenary_file_type);

		let file_name = parent.children('.agent-name').text() + "-itenary" + file_extension;

		_file_download.blobToDataURL(itenary_file, file_name, _this);
	}

	blobToDataURL(url, file_name, _this) {
		fetch(url)
		.then(res => res.blob())
		.then(
			blob => { 
				const _file_download = new File_Download();
				
				_file_download.download_file(blob, file_name, _this);
			});
	}

	get_file_type(itenary_file){
		const limit = itenary_file.indexOf(';');

		let itenary_file_type = itenary_file.substring(5, limit);

		return itenary_file_type;
	}	

	get_extension(file_type){		
		const _file_download = new File_Download();

		let start = file_type.indexOf('/');
		let file_extension = file_type.substring(start + 1);

		if(file_extension.indexOf('plain') >= 0){
			file_extension = 'txt';
		}
		else if(file_extension.indexOf('officedocument') >= 0 || file_extension.indexOf('wordprocessingml') >= 0){
			file_extension = 'docx';
		}

		return file_extension;
	}

	download_file(req, file_name, _this){
		const downloadFile = (blob, fileName) => {
		
			const link = document.createElement('a');

			// create a blobURI pointing to our Blob
			link.href = URL.createObjectURL(blob);
			link.download = fileName;

			// some browser needs the anchor to be in the doc
			document.body.append(link);

			link.click();
			link.remove();

			// in case the Blob uses a lot of memory
			setTimeout(() => {
				URL.revokeObjectURL(link.href);

				$(_this).css({'cursor': '', 'opacity': 1}).prop('disabled', false);
			}, 3000);
		};

		downloadFile(new Blob([req]), file_name);
	}
}

const file_download = function(_this){
	const _file = new File_Download();

	_file.download(_this);
}