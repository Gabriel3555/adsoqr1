(function(){

    let cargarProductos = ()=>{
        let objProducto = new Productos({"listarProductos":"ok"});
        objProducto.listarProductos();
    }
    cargarProductos();

})()