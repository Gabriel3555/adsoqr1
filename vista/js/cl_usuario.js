class Usuario{

    constructor(objData){
        this._objUsuario = objData;
    }


    listarUsuarios(){
        let objData = new FormData();
        objData.append("listarUsuarios",this._objUsuario.listarUsuarios);
        fetch("controlador/usuarioControlador.php",{
            method: 'POST',
            body : objData
        }).then(response=>response.json()).catch(error =>{
            let mensaje = error;
        }).then(response =>{
            let dataSet = [];
            if (response["codigo"] == "200"){
                response["listaUsuarios"].forEach(item => {
                    let objBotones = '<div class="btn-group" role="group" aria-label="Basic example">';
                    objBotones+= '<a href="vista/modulos/carnet.php?user='+item.idusuario+'" target="_blank" id="btnCarnet" type="button" class="btn btn-primary"  documento="'+item.documento+'" nombres="'+item.nombres+" "+item.apellidos+'" url_foto="'+item.url_foto+'" email="'+item.email+'" user="'+item.idusuario+'">Canet</a>';
                    objBotones+= '</div>'
                    let imagen = '<img src="'+item.url_foto+'" alt="" class="mc-imagen">'; 
                    dataSet.push([imagen,item.nombres+" "+item.apellidos,item.documento,item.email,item.telefono,objBotones])
                });
            }
            $("#tablaUsuarios").DataTable({
                destroy:true,
                data: dataSet
            });
        })
    }
}