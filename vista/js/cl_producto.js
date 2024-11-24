class Productos{

    constructor(objData){
        this._objProducto = objData;
    }


    listarProductos(){
        let objData = new FormData();
        objData.append("listarProductos",this._objProducto.listarProductos);
        fetch("controlador/productoControlador.php",{
            method: 'POST',
            body : objData
        }).then(response=>response.json()).catch(error =>{
            let mensaje = error;
        }).then(response =>{
            let dataSet = [];
            if (response["codigo"] == "200"){
                response["listaProductos"].forEach(item => {
                    let objBotones = '<div class="btn-group" role="group" aria-label="Basic example">';
                    objBotones+= '<a href="vista/modulos/codigoBarras.php?producto='+item.idproducto+'" target="_blank" id="btnCodigo" type="button" class="btn btn-primary">Codigo de barras</a>';
                    objBotones+= '</div>'
                    let imagen = '<img src="'+item.url_foto+'" alt="" class="mc-imagen">'; 
                    dataSet.push([imagen,item.descripcion,item.stock,item.precio,objBotones])
                });
            }
            $("#tablaProductos").DataTable({
                destroy:true,
                data: dataSet
            });
        })
    }
}