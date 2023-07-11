function fncSweetAlert(type, text, url)
{
    switch(type)
    {
        //Cuando ocurre un error

        case "error":
            if(url == null)
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: text
                })
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: text
                }).then((result)=>{
                    if(result.value){
                        window.open(url, "_top");
                    }
                })
            }
        break;
        //Cuando es correcto
        case "success":
            if(url==null)
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: text,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                })
            }
            else{
                Swal.fire({
                    icon: 'success',
                    title: 'Confirmación',
                    text: text,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result)=>{
                    if(result.value)
                    {
                        window.open(url, "_top");
                    }
                })
            }
        break;
        case "loading":

		  Swal.fire({
            allowOutsideClick: false,
            icon: 'info',
            text:text
          })
          Swal.showLoading()

        break;  

        /*=============================================
		Cuando necesitamos cerrar la alerta suave
		=============================================*/

		case "close":

		 	Swal.close()
		 	
		break;
    }
}